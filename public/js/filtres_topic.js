//Au chargement de la page on vérifie l'états des filtres (vides ou cochés)
window.addEventListener("load", function () {
    ajax();
}, false);

function display_filtres() {
    var filtres = document.getElementById("display_filtres");
    filtres.style.display = "inline";
    var button_plus = document.getElementById("button_plus");
    button_plus.style.display = "none";
    var button_moins = document.getElementById("button_moins");
    button_moins.style.display = "inline";
}
function hide_filtres() {
    var filtres = document.getElementById("display_filtres");
    filtres.style.display = "none";
    var button_moins = document.getElementById("button_moins");
    button_moins.style.display = "none";
    var button_plus = document.getElementById("button_plus");
    button_plus.style.display = "inline";
}
/*
 @author : Herrenschmidt Félix
 @description : Permet de placer dans un tableau tout les éléments sélectionnés dans le select
 */
function getSelectValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;

    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];

        if (opt.selected) {
            result.push(opt.value);
        }
    }
    return result;
};

/*
 @author : Herrenschmidt Félix
 @description : Fonction AJAX qui permet d'afficher les questions selon les filtres séléctionnés
 */
function ajax(cas) {

    var select_matieres = document.getElementById("ajax_select_matiere");
    var values_matieres = getSelectValues(select_matieres);//values_matieres est un tableau en JS

    var select_promos = document.getElementById("ajax_select_promo");
    var values_promos = getSelectValues(select_promos);

    var select_prof = document.getElementById("ajax_select_prof");
    var values_prof = getSelectValues(select_prof);

    var select_style = document.getElementById("ajax_select_style");
    var values_style = getSelectValues(select_style);

    var select_chap = document.getElementById("ajax_select_chap");
    var values_chap = getSelectValues(select_chap);

    //Bouton Voir Plus :
    var j = 0;
    var limit = 20; // On limite le nombre d'affichage à 20 au 1er affichage de la page
    if (cas === 1) {
        var i = f();
        for (j = 0; j < i; j++) {
            limit += 10; //On ajoute à chaque fois 10 posts
        }
    }

    var data1 = document.getElementById("autocomplete-input").value;
    var data2 = document.getElementById("search").value;

    if (data1.length >= 3 || data2.length >= 3) {
        if (data1.length > data2.length) {
            var xhr = getXMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                    insertData(xhr.responseText);
                    //Pour afficher le loader
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("loader2").style.display = "none";
                } else if (xhr.readyState < 4) {
                    document.getElementById("loader").style.display = "inline";
                    document.getElementById("loader2").style.display = "inline";
                }
            };

            xhr.open("POST", "../Vues/ajax_affichage_topic.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //On protège les variables que l'on transportes, meme en POST
            var tab_promos = encodeURIComponent(values_promos);
            var tab_matieres = encodeURIComponent(values_matieres);
            var tab_prof = encodeURIComponent(values_prof);
            var tab_style = encodeURIComponent(values_style);
            var tab_chap = encodeURIComponent(values_chap);
            //document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
            xhr.send("id_CLASSES=" + tab_promos + "&id_MATIERES=" + tab_matieres + "&id_PROF=" + tab_prof + "&id_STYLE=" + tab_style + "&id_CHAP=" + tab_chap + "&LIMIT=" + limit + "&data=" + data1); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php


        } else {
            var xhr = getXMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                    insertData(xhr.responseText);
                    //Pour afficher le loader
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("loader2").style.display = "none";
                } else if (xhr.readyState < 4) {
                    document.getElementById("loader").style.display = "inline";
                    document.getElementById("loader2").style.display = "inline";
                }
            };

            xhr.open("POST", "../Vues/ajax_affichage_topic.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //On protège les variables que l'on transportes, meme en POST
            var tab_promos = encodeURIComponent(values_promos);
            var tab_matieres = encodeURIComponent(values_matieres);
            var tab_prof = encodeURIComponent(values_prof);
            var tab_style = encodeURIComponent(values_style);
            var tab_chap = encodeURIComponent(values_chap);
            //document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
            xhr.send("id_CLASSES=" + tab_promos + "&id_MATIERES=" + tab_matieres + "&id_PROF=" + tab_prof + "&id_STYLE=" + tab_style + "&id_CHAP=" + tab_chap + "&LIMIT=" + limit + "&data=" + data2); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php

        }
    } else {
        var xhr = getXMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                insertData(xhr.responseText);
                //Pour afficher le loader
                document.getElementById("loader").style.display = "none";
            } else if (xhr.readyState < 4) {
                document.getElementById("loader").style.display = "inline";
            }
        };

        xhr.open("POST", "../Vues/ajax_affichage_topic.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //On protège les variables que l'on transportes, meme en POST
        var tab_promos = encodeURIComponent(values_promos);
        var tab_matieres = encodeURIComponent(values_matieres);
        var tab_prof = encodeURIComponent(values_prof);
        var tab_style = encodeURIComponent(values_style);
        var tab_chap = encodeURIComponent(values_chap);
        //document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
        xhr.send("id_CLASSES=" + tab_promos + "&id_MATIERES=" + tab_matieres + "&id_PROF=" + tab_prof + "&id_STYLE=" + tab_style + "&id_CHAP=" + tab_chap + "&LIMIT=" + limit); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php

    }

    /*

    xhr.open("POST", "../Vues/ajax_affichage_topic.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //On protège les variables que l'on transportes, meme en POST
    var tab_promos = encodeURIComponent(values_promos);
    var tab_matieres = encodeURIComponent(values_matieres);
    var tab_prof = encodeURIComponent(values_prof);
    var tab_style = encodeURIComponent(values_style);
    var tab_chap = encodeURIComponent(values_chap);
    //document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
    xhr.send("id_CLASSES=" + tab_promos + "&id_MATIERES=" + tab_matieres + "&id_PROF=" + tab_prof + "&id_STYLE=" + tab_style + "&id_CHAP=" + tab_chap + "&LIMIT=" + limit); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php
*/
}


function insertData(sData) {
    var oSelect = document.getElementById("ajax_inner");
    oSelect.innerHTML = sData;
};

function f() {
    f.count = ++f.count || 1;
    return f.count;
}


