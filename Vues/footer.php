<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 14:02
 */
?>
<footer class="page-footer teal">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Stud'Yncréa</h5>
                <p class="grey-text text-lighten-4">Retrouvez tous les sujets et leurs corrections à l'ISEN-Toulon.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Liens</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Annales</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Demandes</a></li>
                    <li><a class="grey-text text-lighten-3" href="http://yncrea.fr/">Yncréa</a></li>
                    <li><a class="grey-text text-lighten-3" href="http://isen-toulon.fr/">ISEN-Toulon</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2017 - All rights reserved - Desrumaux Guillaume - Herrenschmidt Félix - Chamayou Guilhem - Dorian Picard
        </div>
    </div>
</footer>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script type="text/javascript">
    function setActive() {
        var aObj = document.getElementById('nav').getElementsByTagName('a');
        for (var i = 0; i < aObj.length; i++) {
            if (document.baseURI.indexOf(aObj[i].href) >= 0) {
                aObj[i].parentNode.className = 'active';
            }
        }
    }
    window.onload = setActive;

    $(".button-collapse").sideNav();
    <?php
    if(isset($ScriptPost))
    {
    ?>
    jQuery(document).ready(function ($) {
        $('.reply').click(function (e) {
            e.preventDefault();
            var $form = $('#comments');
            var $this = $(this);
            var id_comment_father = $this.data('id');
            var $comment = $('#comment-' + id_comment_father);
            $comment.after($form);
            $form.find('h5').text('Répondre à ce commentaire');
            $('#id_comment_father').val(id_comment_father);
        });
    });


    <?php
    }
    ?>

</script>
<?php
if (isset($select)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').material_select();
        });
        $(document).ready(function () {
            $('.materialboxed').materialbox();
        });
    </script>
    <?php
}
if (isset($dashboardScript)) {
    ?>
    <script src="js/oXHR.js"></script>
    <script type="text/javascript">

        window.onload = function () {
            var elements = document.getElementsByClassName('delete');
            for (var i = 0; i < elements.length; ++i) {
                elements[i].addEventListener('click', function (event) {
                    var toElement = event.toElement;
                    if (event.toElement.localName == "i") {
                        toElement = event.toElement.parentElement;
                    }
                    id = toElement.id;
                    delete_post(id, toElement);
                }, false);
            }
        };

        function delete_post(id, element) {
            var value_id = id.split("-").pop();

            var xhr = getXMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                    deleteData(xhr.responseText, element);
                }
            };

            xhr.open("POST", "../Vues/ajax_delete_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //On protège les variables que l'on transportes, meme en POST
            var id_post = encodeURIComponent(value_id);
            var token = encodeURIComponent('<?= App::getAuth()->getSession()->read('token'); ?>');
            xhr.send("id_post=" + id_post + "&token=" + token); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php
        }

        function deleteData(data, element) {
            if (data == '1') {
                var td = element.parentElement.parentElement;
                td.style.display = "none";
            }
        }
    </script>
    <?php
}
if (isset($Scriptcomment)) {
    ?>
    <script src="js/oXHR.js"></script>
    <script type="text/javascript">

        jQuery(document).ready(function ($) {
            $('.delete').click(function (e) {
                e.preventDefault();
                var id = this.id;
                var $element = $('#comment-' + id);
                delete_comment(id, $element);
            });
        });

        function delete_comment(id, element) {
            var xhr = getXMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                    deleteData(xhr.responseText, element);
                }
            };

            xhr.open("POST", "../Vues/ajax_delete_comment.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //On protège les variables que l'on transportes, meme en POST
            var id_comment = encodeURIComponent(id);
            var token = encodeURIComponent('<?= App::getAuth()->getSession()->read('token'); ?>');
            xhr.send("id_comment=" + id_comment + "&token=" + token); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php
        }

        function deleteData(data, element) {
            if (data != 'error' || date != 'false') {
                $ids = JSON.parse(data);
                for (var i = 0; i < $ids.length; ++i) {
                    $('#comment-' + $ids[i]).hide();
                }
                $("#allcomments").prepend("<div id=\"message\" class=\"green white-text card-panel\">Votre commentaire a bien été supprimé</div>");
                setTimeout(function () {
                    $("#message").remove();
                }, 5000);
            }
        }
    </script>
    <?php
} ?>
</body>
</html>
