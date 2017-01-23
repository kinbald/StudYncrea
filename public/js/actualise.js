/*
    @author : Herrenschmidt Félix
    @description : Permet de gérer les checkbox des matières, pour l'instant on gère que math et physique
    */
    document.addEventListener("DOMContentLoaded", function (event) {
        var _selector1 = document.querySelector('input[name=check1]');
        _selector1.addEventListener('change', function (event) {
            if (_selector2.checked && _selector1.checked){
                ajax(12);//12 pour maths et physique
            }
            else{
                if (_selector1.checked) {
                    ajax(10);//10 pour math
                }
                else{ //11 pour physique
                    if (_selector2.checked){
                        ajax(11);
                    }
                    else{
                        ajax(1);
                    }
                }  
            }   
        });
        var _selector2 = document.querySelector('input[name=check2]');
        _selector2.addEventListener('change', function (event) {
            if (_selector2.checked && _selector1.checked){
                ajax(12);//12 pour maths et physique
            }
            else{
                if (_selector2.checked) {
                    ajax(11);//10 pour math
                }
                else{ //11 pour physique
                    if (_selector1.checked){
                        ajax(10);
                    }
                    else{
                        ajax(1);
                    }
                }
            }
        });
    });
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
    function ajax(verif){
    if (verif === 10 || verif === 11 || verif === 12)//Pour les checkbox de matières
    {
        var values = verif;
    }
    else
    {
        var selectDepart = document.getElementById("ajax_select");
        var values = getSelectValues(selectDepart);//values est un tableau en JS 
    }

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

    xhr.open("POST", "../Vues/ajax_affichage_blog.php", true); 
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    var valeur_option = encodeURIComponent(values);//On protège la variable que l'on transporte, meme en POST
    document.getElementById("hide").style.display = "none";//Je fais disparaitre les questions de départ
    xhr.send("id_CLASSES=" + valeur_option); //J'envoie mon tableau d'éléments en POST
}


function insertData(sData) { 
    var oSelect = document.getElementById("ajax_inner"); 
    oSelect.innerHTML = sData;
};



