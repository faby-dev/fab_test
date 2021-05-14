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
        let sexe = $('#sexe').val();    
        let date = $(this).find('input[name="datedenaissance"]').val();    

        let jsonEnvoi = JSON.stringify({ "nom": nom, "prenom": prenom, "sexe": sexe, "dateDeNaissance": date })         
      
        
       $.ajax({
        url : 'http://localhost:3000/etudiant/create',
        method: "POST",
        data: jsonEnvoi,
        dataType: "json",
        success: function(response){
            console.log(response);
            $("#exampleModal").modal('hide')
        },     
        error: function(response) {
            console.log(response)
        }       
        
        })  
         
        
    });
    
})