$("#form").on('submit', function() {
    if ($("#password").val() != $("#confirm_password").val()) {
        //implémntez votre code
        alert("Les deux mots de passe saisies sont différents");
        alert("Merci de renouveler l'opération");
        return false;
    }
});