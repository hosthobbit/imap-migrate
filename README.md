# IMAP Migrate

A lightweight PHP tool for moving a mailbox from one IMAP server to another, built by Host Hobbit for client email migrations.

Enter the source and destination mailbox details in a web form and every message in the source inbox is copied across, **byte for byte**, keeping:

- attachments and HTML formatting (messages are copied raw, not rebuilt)
- each message's original received date, so the new inbox sorts correctly
- read / unread status

## Requirements

- PHP 7.4 or newer with the `imap` extension enabled
- [Composer](https://getcomposer.org/)
- Both servers reachable over IMAP with SSL on port 993

## Installation

```bash
git clone https://github.com/hosthobbit/imap-migrate.git
cd imap-migrate
composer install
```

Then upload the folder (including `vendor/`) to a PHP-enabled web server.

## Usage

1. Open `index.html` in a browser, for example `https://yourdomain.com/imap-migrate/`.
2. Fill in the **source** server, username and password.
3. Fill in the **destination** server, username and password.
4. Click **Migrate**. The result is shown when the copy finishes.

## Security

This form accepts mailbox passwords and connects to whatever server it's given. **Don't leave it publicly accessible.** Protect the folder with HTTP authentication or an IP allow-list, always serve it over HTTPS, and remove it from the server when the migration is done.

## Limitations

- Copies the **INBOX** folder only (not Sent, Drafts or custom folders).
- Runs as a single web request, so very large mailboxes may hit PHP's `max_execution_time`; raise it or migrate in batches.
- The progress bar is indicative only; it doesn't track individual messages.

For large or multi-account migrations, Host Hobbit can run them for you. See below.

---

## About Host Hobbit

Built and maintained by **[Host Hobbit Ltd](https://hosthobbit.com)**: managed WordPress hosting, WHM/cPanel and VPS administration, security hardening and AI automation for businesses in the UK.

Need help deploying this, or want something similar built for your business? [Get in touch](https://hosthobbit.com).
