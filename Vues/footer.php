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
if (isset($select)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').material_select();
        });
    </script>
    <?php
}
?>
</body>
</html>
