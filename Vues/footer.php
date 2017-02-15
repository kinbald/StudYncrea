<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 14:02
 */
?>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<?php
if (isset($init))
{
    ?>
    <script type="text/javascript">
        $(".button-collapse").sideNav();
        $(document).ready(function() {
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
        $(document).ready(function(){
            $('.materialboxed').materialbox();
        });
    </script>
    <?php
}?>
</body>
</html>
