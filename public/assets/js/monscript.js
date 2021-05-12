$(document).ready(function(){    
    $("#affiche").on('click', function(){
        $("#exampleModal").modal('show')
    });
    $("#ferm").on("click", function(){
        $("#exampleModal").modal('hide')
    });
    $('#ajoutEtudiants').on('submit', function(e){
        e.preventDefault();
       let nom =  $(this).find('input[name="nom"]').val();
       let prenom = $(this).find('input[name="prenom"]').val();
       let sexe = $(this).find('option:selected');
       console.log(nom);
       console.log(prenom);
       console.log(sexe);
    })
})