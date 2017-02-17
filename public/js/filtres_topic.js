//Au chargement de la page on vérifie l'états des filtres (vides ou cochés)
window.addEventListener("load", function () {
        ajax();
    }, false);
/*
    @author : Herrenschmidt Félix
    @description : Permet de placer dans un tableau tout les éléments sélectionnés dans le select
    */
    function getSelectValues(select) {
        var result = [];
        var options = select && select.options;
        var opt;

        for (var i=0, iLen=options.length; i<iLen; i++) {
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
    function ajax(){

        var select_matieres = document.getElementById("ajax_select_matiere");
        var values_matieres = getSelectValues(select_matieres);//values_matieres est un tableau en JS 

        var select_promos = document.getElementById("ajax_select_promo");
        var values_promos = getSelectValues(select_promos); 

        var select_prof = document.getElementById("ajax_select_prof");
        var values_prof = getSelectValues(select_prof); 

        var select_style = document.getElementById("ajax_select_style");
        var values_style = getSelectValues(select_style);

        var xhr = getXMLHttpRequest();
        
        xhr.onreadystatechange = function(){ 
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) { 
            //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
            insertData(xhr.responseText);
            //Pour afficher le loader
            document.getElementById("loader").style.display = "none"; 
        } else if (xhr.readyState < 4) { 
            document.getElementById("loader").style.display = "inline"; 
        } 
    }

    xhr.open("POST", "../Vues/ajax_affichage_topic.php", true); 
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    //On protège les variables que l'on transportes, meme en POST
    var tab_promos = encodeURIComponent(values_promos);
    var tab_matieres = encodeURIComponent(values_matieres);
    var tab_prof = encodeURIComponent(values_prof);
    var tab_style = encodeURIComponent(values_style);
    //document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
    xhr.send("id_CLASSES=" + tab_promos + "&id_MATIERES=" + tab_matieres + "&id_PROF="+ tab_prof + "&id_STYLE="+ tab_style); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php
}


function insertData(sData) { 
    var oSelect = document.getElementById("ajax_inner"); 
    oSelect.innerHTML = sData;
};



