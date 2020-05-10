<script>
    async function parseEmotes(message) {
        let s = message.html();
        let emotes = s.match(/:([a-zA-Z]+):/g);

        if (emotes != null && emotes.length) {
            let trimmed = [];
            let parsed = [];

            emotes.forEach(element => {
                trimmed.push(element.replace(/:/g, ''));
            });

            for (let i = 0; i < trimmed.length; i++) {
                await fetch('/storage/emoticons/' + trimmed[i] + '.png').then(response => {
                    if (response.status === 200) {
                        parsed.push(emotes[i]);
                    }
                });
            }

            for (let i = 0; i < parsed.length; i++) {
                let path = parsed[i].replace(/:/g, '');
                s = s.replace(parsed[i], `<img src="/storage/emoticons/${path}.png" title="${path}">`);
            }
            return message.html(s);
        } else {
            return false;
        }
    }
</script>