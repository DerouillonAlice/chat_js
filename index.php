<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat jQuery</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script>
    $(document).ready(function(){
        let alreadyWizz = [];
        var wizzSound = new Audio('wo.mp3');

        function afficher() {
            $.ajax({
                url: 'afficher.php',
                type: 'GET',
                success: function(data) {
                    $('#affiche').html(data);
                    if ($('[data-wizz="1"]').length > 0) {
                        $('[data-wizz="1"]').each(function(){
                            if(alreadyWizz.includes($(this).data('id'))) {
                                return;
                            }
                            alreadyWizz.push($(this).data('id'));
                            $(this).addClass('wizz');
                            wizzSound.play();
                        })
                    }

                    
                }
            });
        }
                   
        afficher();

        function envoyerMessage() {
            var pseudo = $('#pseudo').val();
            var message = $('#message').val();
            var date = $('#date').val();

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
        let nbwizz=0;
        $('#message').keydown(function(event) {
            if (event.key === "Enter") {
                envoyerMessage();
            }
        });
        
        $('#envoyer').click(function() {
            envoyerMessage();
        });

        setInterval(afficher, 1000);
    });
    </script>
</head>
<body>

    <div id="affiche">Chargement des messages ...</div>

    <div class="inputs">

    <input type="text" id="pseudo" placeholder="Votre pseudo">
    <input type="text" id="message" placeholder="Votre message">
    <input type="submit" id="envoyer" value="Envoyer">

    </div>
    



    
<script>
setTimeout(() => {
    const wizzElements = document.querySelectorAll('.wizz'); 
    wizzElements.forEach((element) => {
        element.classList.remove('wizz');
        wizzSound.stop();
    });
}, 2000);
</script>


</body>
</html>

