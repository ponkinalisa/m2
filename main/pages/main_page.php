<?php 

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личная библиотека</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Подключение стилей -->
</head>
<body>
    <!-- Главная страница (список книг) -->
    <div id="main-content">
        <div id="book-list" class="section">
            <h2>Список книг</h2>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Автор</th>
                        <th>Год издания</th>
                        <th>Жанр</th>
                        <th>Обложка</th>
                        <th>Номер страницы</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Книги будут отображаться здесь через серверный рендеринг -->
                    <tr>
                        <td>Название книги</td>
                        <td>Автор</td>
                        <td>Год</td>
                        <td>Жанр</td>
                        <td><img src="bookfoto.jpg" alt="Обложка книги" width="50"></td>
                        <td>45</td> <!-- Номер страницы, на которой остановился читатель -->
                        <td>
                            <a href="/book/view">Просмотреть</a>
                            <a href="/book/edit">Редактировать</a>
                            <a href="/book/delete" onclick="return confirm('Удалить книгу?')">Удалить</a>
                        </td>
                    </tr>
                    <!-- Пагинация -->
                    <tr>
                        <td colspan="7">
                            <button>Предыдущая</button>
                            <button>Следующая</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="" >Добавить книгу</a>
        </div>

        <!-- Форма добавления/редактирования книги -->
        <div id="book-form" class="section" >
            <h2>Добавить/Редактировать книгу</h2>
            <form action="../php/add_book.php" method="POST" enctype="multipart/form-data">
                <label for="title">Название книги:</label>
                <input type="text" id="title" name="title" required maxlength="100">

                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" required maxlength="100">

                <label for="genre">Жанр:</label>
                <select id="genre" name="genre" required>
                    <option>Фантастика</option>
                    <option>Нон-фикшн</option>
                    <option>Детектив</option>
                    <!-- Другие жанры -->
                </select>

                <label for="year">Год издания:</label>
                <input type="number" id="year" name="year" required min="1800" max="2025">

                <label for="description">Описание:</label>
                <textarea id="description" name="description" maxlength="500"></textarea>

                <label for="cover">Обложка книги (jpg, до 3 МБ):</label>
                <input type="file" id="cover" name="cover" accept="image/jpeg">

                <label for="page-number">Номер страницы:</label>
                <input type="number" id="page-number" name="page-number" min="1">

                <button type="submit">Сохранить</button>
            </form>
        </div>

        <!-- Просмотр книги -->
        <div id="book-view" class="section" >
            <h2>Просмотр книги</h2>
            <h3>Название книги</h3>
            <p>Автор: Автор книги</p>
            <p>Год издания: Год</p>
            <p>Жанр: Жанр</p>
            <img src="cover.jpg" alt="Обложка книги" width="100">
            <p>Описание книги...</p>
            <p>Номер страницы: <span id="current-page">45</span></p> <!-- Здесь выводится текущий номер страницы -->
            <a href="/book/edit">Редактировать</a> |
            <a href="/book/delete" onclick="return confirm('Удалить книгу?')">Удалить</a>
        </div>
    </div>

</body>
</html>
