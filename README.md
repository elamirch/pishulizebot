# Pishulizebot (Also Gladiamemebot)

## Description
These are two Telegram bots written in pure PHP that allow users to generate memes on the fly. Users can send background images/videos and captions to the bot, and it will return a meme with the given text overlaid. The bot supports 25 different memes.

## Features
- Supports multiple languages (currently English & Persian)
- Supports both image/video and text-based meme generation
- Easy to deploy and configure
- Uses ffmpeg

## Requirements
- PHP 8.2+
- Web server with SSL (for Telegram webhook support)
- Telegram Bot API Token
- Ffmpeg
- Git LFS

## Installation

1. **Create a Telegram bot**
   - Open Telegram and chat with [BotFather](https://t.me/BotFather)
   - Use `/newbot` and follow the instructions to get your bot token

2. **Set up your server**
   - Install PHP and a web server (Apache/Nginx)
   - Install the requirements mentioned above

3. **Clone the repository**
   ```bash
   git clone https://github.com/elamirch/pishulizebot.git
   ```

4. **Set Up the Database**
- Install MySQL or MariaDB if not already installed.
- Create a new database and user, then grant necessary permissions.
```bash
mysql -u root -p
CREATE DATABASE meme_bot;
CREATE USER 'meme_user'@'localhost' IDENTIFIED BY 'yourpassword';
GRANT ALL PRIVILEGES ON meme_bot.* TO 'meme_user'@'localhost';
FLUSH PRIVILEGES;
```
- Add the database credentials to the `.env` file.

5. **Configure the bot**
    - Copy `sample_env` and rename it to `.env`
    - Configure the `.env` file with the following details:
        - Telegram Bot API key
        - Your Telegram username
        - Channel ID
        - MySQL/MariaDB credentials

6. **Set up the webhook**
    - Set up a web server (Apache, Nginx, etc.) and move the bot files to the root directory:
    ```sh
    mv pishulizebot/ /path/to/webserver/root
    ```
    - Configure the bot's webhook by running:
    ```bash
    curl -X POST "https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://yourdomain.com/run_gladiamemebot.php"
    ```
    > **Note:** Replace `{BOT_TOKEN}` with your actual bot token, `yourdomain.com` with your web server's domain and choose whether to run `run_pishulizebot.php` (Fa) or `run_gladiamemebot.php` (En).

## Contributing
Pull requests are welcome! Feel free to submit issues or suggestions.

## License
This project is licensed under the the **Mozilla Public License 2.0 (MPL 2.0)**.
