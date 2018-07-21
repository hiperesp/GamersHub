<?php
function AddMedalha($userId, $medalhaId){
    //Procura no banco de dados se a medalha existe
        //Caso a medalha exista:
            //Verifica se o usuário tem
                //Caso ele tenha, não faz nada e retorna true;
                //Caso ele não tenha, cadastra a medalha na conta dele e retorna true;
        //Caso a medalha não exista:
            //retorna false;
}

function SetRank($userId, $tagId){
    //Procura no banco de dados se o rank existe
        //Caso o rank exista:
            //Caso exista, altera o rank e retorna true;
        //Caso o rank não exista:
            //retorna false e não faz nada;
}
