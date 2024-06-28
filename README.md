# IMAP Email Migration Tool

This tool allows you to migrate emails from one IMAP server to another. It provides a simple web interface for users to input the source and destination server details and perform the migration with a progress indicator.

## Features

- Migrate emails from a source IMAP server to a destination IMAP server.
- Simple web interface for inputting server details.
- Progress bar to indicate the migration progress.

## Prerequisites

- PHP 7.2 or higher
- Composer

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/hosthobbit/imap-migrate.git
   cd imap-migrate
Install Composer dependencies:

Make sure you have Composer installed. Then run:

bash
Copy code
composer install
Deploy the files to your web server:

Ensure the following files and directories are deployed to your web server:

migrate.php
index.html
composer.json
composer.lock
vendor directory
Usage
Open the index.html file in your web browser by navigating to the appropriate URL (e.g., http://yourdomain.com/migrate/index.html).

Fill in the source and destination server details:

Source Server:
Server: The IMAP server address of the source email server.
User: The username for the source email account.
Password: The password for the source email account.
Destination Server:
Server: The IMAP server address of the destination email server.
User: The username for the destination email account.
Password: The password for the destination email account.
Click the "Migrate" button to start the migration process. The progress bar will indicate the migration progress, and the result will be displayed upon completion.

Example Directory Structure
Your project directory should look something like this:

csharp
Copy code
imap-migrate/
├── migrate.php
├── index.html
├── composer.json
├── composer.lock
└── vendor/
Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss any changes.

License
This project is licensed under the MIT License. See the LICENSE file for more details.

