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
<?php
if (isset($init)) {
    ?>
    <script type="text/javascript">
        $(".button-collapse").sideNav();
        $(document).ready(function () {
            $('select').material_select();
        });
        //     $('input.autocomplete').autocomplete({
        //         data: {
        //           "Apple": null,
        //           "Microsoft": null,
        //           "Google": 'http://placehold.it/250x250'
        //       },
        //     limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
        // });
    </script>
    <?php
}

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
} ?>
</body>
</html>
