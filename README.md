Here's a description you can use for GitHub repository:

---

# Online Book Store Management System

This project is a web-based **Online Book Store Management System** that enables administrators to manage an online book store efficiently. It provides an admin panel for adding, editing, and deleting books, categories, and awards, and allows users to access available books along with their details and PDF versions. This project is built using PHP with a MySQL database, and it uses Bootstrap for a responsive user interface.

## Features

### Admin Panel
- **Book Management**: Admins can add new books with title, author, description, category, cover image, and PDF file. They can also edit or delete existing books.
- **Category Management**: Admins can create, update, or delete book categories to organize the book collection.
- **Award Management**: Admins can add awards to specific books, and edit or remove awards as necessary.
- **User Management**: Admins have access to a list of users registered in the system.
- **Session-Based Access Control**: Only logged-in admins can access the admin panel features.

### Public User Interface
- **View Books**: Users can browse available books, view details, and read PDFs.
- **Category Navigation**: Users can filter books based on categories.

### Admin ID
- **ID**: ab@gmail.com
- **Password**: 12345678

## Project Structure

- **index.php**: Main page accessible to all users.
- **admin_panel.php**: Main admin panel for managing books, categories, and awards.
- **account/login.php**: Login page for admin authentication.
- **uploads/cover/**: Directory for book cover images.
- **uploads/file/**: Directory for book PDF files.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/bot-in-lab/Online-Book-Store-Management-System.git
    ```
2. Set up a MySQL database and import the SQL file provided.
3. Update `db_conn.php` with your database connection details.
4. Start a local server (e.g., XAMPP, WAMP) and navigate to `index.php` for the main page or `admin_panel/admin_panel.php` for the admin panel.

## Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, Bootstrap
- **Server**: Apache (for local development)

## Video
https://youtu.be/TKPlG-6lDAk


---

This description provides an overview of the project’s purpose, features, installation instructions, and technologies used.
