# manage_lines.py

import mysql.connector
from mysql.connector import Error
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
from datetime import datetime
import config 

sns.set(style="whitegrid")
plt.rcParams.update({'figure.max_open_warning': 0})

def get_db_connection():
    """
    Встановлює з'єднання з базою даних MySQL.
    Повертає об'єкт з'єднання або none у випадку помилки.
    """
    try:
        connection = mysql.connector.connect(**config.DB_CONFIG)
        if connection.is_connected():
            print("Підключено до бази даних.")
            return connection
    except Error as e:
        print(f"Помилка підключення до бази даних: {e}")
        return None

def add_entries_for_all_lines():
    """
    Додає записи до бази даних для всіх ліній одночасно.
    Автоматично визначає status_id та remarks на основі current_strength.
    Повертає scan_time для подальшого використання.
    """
    connection = get_db_connection()
    if connection is None:
        return None

    cursor = connection.cursor()

    try:
        cursor.execute("SELECT id, line_number FROM `lines`")
        lines = cursor.fetchall()
        if not lines:
            print("Таблиця 'lines' порожня або не існує.")
            return None

        print("Доступні лінії:")
        for line in lines:
            print(f"{line[0]}: Лінія {line[1]}")

        scan_time_input = input("Введіть час сканування (YYYY-MM-DD HH:MM:SS) або залиште порожнім для поточного часу: ")
        if scan_time_input.strip() == "":
            scan_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(f"Використовується поточний час: {scan_time}")
        else:
            try:
                datetime.strptime(scan_time_input, '%Y-%m-%d %H:%M:%S')
                scan_time = scan_time_input
            except ValueError:
                print("Неправильний формат часу. Використовується поточний час.")
                scan_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

        entries = []

        for line in lines:
            print(f"\nВведення даних для Лінії {line[1]} (ID: {line[0]}):")
            while True:
                try:
                    current_strength = float(input("  Введіть значення струму (current_strength): "))
                    break
                except ValueError:
                    print("  Неправильний формат числа. Спробуйте ще раз.")

            if current_strength == 0:
                status_id = 3
                remarks = "Розрив"
            elif 0.1 <= current_strength <= 8.0:
                status_id = 4
                remarks = "Нестача"
            elif 8.1 <= current_strength <= 15.0:
                status_id = 1
                remarks = "Нормальна робота"
            elif current_strength >= 15.1:
                status_id = 2
                remarks = "Перевантаження"
            else:
                print("  Значення струму не відповідає жодному з діапазонів. Використовується статус 1 та примітка 'Нормальна робота'.")
                status_id = 1
                remarks = "Нормальна робота"

            print(f"  Визначено статус: {status_id}, Примітка: {remarks}")

            entries.append((line[0], scan_time, current_strength, status_id, remarks))

        insert_query = """
            INSERT INTO line_current_readings (line_id, scan_time, current_strength, status_id, remarks)
            VALUES (%s, %s, %s, %s, %s)
        """
        cursor.executemany(insert_query, entries)
        connection.commit()
        print("\nВсі записи успішно додано до бази даних.")

        return scan_time 

    except Error as e:
        print(f"Помилка при додаванні записів: {e}")
        return None
    finally:
        cursor.close()
        connection.close()

def generate_bar_chart(scan_time):
    """
    Створює стовпчасту діаграму на основі даних для заданого часу сканування.
    Зберігає діаграму з назвою, що включає дату та час.
    """
    connection = get_db_connection()
    if connection is None:
        return

    try:
        query = """
            SELECT ln.line_number, lr.current_strength
            FROM line_current_readings lr
            JOIN `lines` ln ON lr.line_id = ln.id
            WHERE lr.scan_time = %s
        """
        df = pd.read_sql(query, connection, params=(scan_time,))

        if df.empty:
            print("Немає даних для відображення.")
            return

        plt.figure(figsize=(10, 6))
        sns.barplot(x='line_number', y='current_strength', data=df, palette='viridis')
        plt.title(f'Поточна сила струму за часом {scan_time}')
        plt.xlabel('Лінія')
        plt.ylabel('Сила струму (A)')
        plt.tight_layout()
        filename = f'C:/xampp/htdocs/БЕК/bars/bar_chart_{scan_time.replace(":", "-")}.png'
        plt.savefig(filename)
        plt.show()
        print(f"Стовпчаста діаграма збережена як '{filename}'.")

    except Error as e:
        print(f"Помилка при отриманні даних: {e}")
    finally:
        connection.close()

def generate_time_series_plots():
    """
    Створює графіки часу для кожної лінії на основі всіх даних у базі.
    Зберігає кожен графік з назвою, що включає номер лінії.
    """
    connection = get_db_connection()
    if connection is None:
        return

    try:
        query = """
            SELECT ln.line_number, lr.scan_time, lr.current_strength
            FROM line_current_readings lr
            JOIN `lines` ln ON lr.line_id = ln.id
            ORDER BY lr.scan_time ASC
        """
        df = pd.read_sql(query, connection)

        if df.empty:
            print("Немає даних для відображення.")
            return

        df['scan_time'] = pd.to_datetime(df['scan_time'])

        lines = df['line_number'].unique()

        for line in lines:
            line_data = df[df['line_number'] == line]
            plt.figure(figsize=(12, 6))
            sns.lineplot(x='scan_time', y='current_strength', data=line_data, marker='o')
            plt.title(f'Сила струму по Лінії {line} за часом')
            plt.xlabel('Час сканування')
            plt.ylabel('Сила струму (A)')
            plt.xticks(rotation=45)
            plt.tight_layout()
            filename = f'time_series_line_{line}.png'
            plt.savefig(filename)
            plt.show()
            print(f"Графік для Лінії {line} збережено як '{filename}'.")

    except Error as e:
        print(f"Помилка при отриманні даних: {e}")
    finally:
        connection.close()

def main():
    """
    Основна функція, яка послідовно виконує всі необхідні операції:
    1. Додає записи до бази даних.
    2. Генерує стовпчасту діаграму.
    3. Генерує графіки часу для кожної лінії.
    """
    print("\n--- Додавання записів до бази даних ---")
    scan_time = add_entries_for_all_lines()

    if scan_time:
        print("\n--- Формування стовпчастої діаграми ---")
        generate_bar_chart(scan_time)

        print("\n--- Формування графіків часу для кожної лінії ---")
        generate_time_series_plots()

        print("\nВсі операції завершено.")
    else:
        print("\nНе вдалося додати записи до бази даних. Операції не будуть продовжені.")

if __name__ == "__main__":
    main()
