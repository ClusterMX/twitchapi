<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bot</title>
</head>
<body>
    <script src="/js/tmi.min.js"></script>
    <script>
        const client = new tmi.Client({
            options: { debug: true },
            identity: {
                username: 'chenchizkanbot',
                password: 'oauth:azr8oek1cmwzdavsk80tqfumbwcs1i'
            },
            channels: [ 'chenchizkan' ]
        });

        client.connect();

        client.on('message', (channel, tags, message, self) => {
            // Ignore echoed messages.
            if(self) return;

            if(message.toLowerCase() === '!hello') {
                // "@alca, heya!"
                client.say(channel, `@${tags.username}, heya!`);
            }
        });
    </script>
</body>
</html>
