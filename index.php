<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat jQuery</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script>
$(document).ready(function() {
    let alreadyWizz = [];
    var wizzSound = new Audio('wo.mp3');

    function afficher() {
        $.ajax({
            url: 'afficher.php',
            type: 'GET',
            success: function(data) {
                let previousWizz = {};
                $('[data-wizz="1"]').each(function() {
                    previousWizz[$(this).data('id')] = true;
                });

                $('#affiche').html(data);

                $('[data-wizz="1"]').each(function() {
                    if (alreadyWizz.includes($(this).data('id'))) {
                        return;
                    }
                    alreadyWizz.push($(this).data('id'));

                    $(this).addClass('wizz');
                    wizzSound.play();
                });
            }
        });
    }

    afficher();

    function envoyerMessage() {
        var pseudo = $('#pseudo').val();
        var message = $('#message').val();

        if (pseudo && message) {
            $.ajax({
                url: 'dire.php',
                type: 'GET',
                data: { pseudo: pseudo, message: message },
                success: function() {
                    $('#message').val('');
                    afficher();
                }
            });
        } else {
            alert("Veuillez entrer un pseudo et un message.");
        }
    }

    $('#message').keydown(function(event) {
        if (event.key === "Enter") {
            envoyerMessage();
        }
    });

    $('#envoyer').click(function() {
        envoyerMessage();
    });

    setInterval(afficher, 1000);

    setTimeout(() => {
        const wizzElements = document.querySelectorAll('.wizz'); 
        wizzElements.forEach((element) => {
            element.classList.remove('wizz');
        });
    }, 2000);
});

    </script>
</head>

<body>

<div id="affiche">Chargement des messages ...</div>

<div class="inputs">
    <input type="text" id="pseudo" placeholder="Votre pseudo">
    
    <div class="message-wrapper">
        <input type="text" id="message" placeholder="Votre message">
        <img src="send.png" alt="Envoyer" id="envoyer" class="send-btn">
    </div>
</div>





</body>
</html>

