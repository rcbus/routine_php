<?php
$PATH = "../";
$PAGENAME = "routine";
$PAGETITLE = "Rotina";

include_once $PATH.'preLoad.php';

include_once $PATH.'security.php';

if($security===true){
	$page->useBootstrap();

	$corpo = new space($page, "corpo");
	
    $action = $page->s->g("action");

    if(!$action){
        $bp = new bootstrap($corpo,"bp");
        $bp->line();
        $bp->button($name = "cadastrar","+ Cadastrar","btn-primary","12,3,3,2,2");
        $bp->java->setGoToPage("click",$name,THIS,"action","cadastrar","","@".$PAGENAME);
    }else if($action=="cadastrar" || $action=="modificar"){
        $rowA = array();
        if($action=="modificar"){
            $selA = new iSelect($idsa,"routine");
            $selA->where("idRoutine","=",$page->s->g("idRoutine"));

            if($selA->exe()===false){
                msgError("Houve uma falha ao tentar carregar os dados!".administrador.$idsa->getError(1));
            }else{
                $rowA = $selA->read();
                $status = $rowA['statusRoutine'];
            }
        }

        if(isset($_POST['FORM_form'])){
            $_POST['descricaoRoutine'] = $page->clearString($_POST['descricaoRoutine'],false,true);

            if(strlen($_POST['descricaoRoutine'])==0){
                msgError("Descreva a rotina!");
            }else if(strlen($_POST['usuarioResponsavelRoutine'])==0){
                msgError("Escolha um responsável!");
            }else if($action=="cadastrar"){
                $insA = new iInsert($idsa,"routine");
                $insA->set("dataCriacao",time());
                $insA->set("dataModificacao",time());
                $insA->set("historico",$page->getHistText());
                $insA->set("filialRoutine",$page->s->getLoginFilial());
                $insA->set("usuarioRoutine",$page->s->getLoginId());
                $insA->set("usuarioResponsavelRoutine",$_POST['usuarioResponsavelRoutine']);
                $insA->set("descricaoRoutine",$_POST['descricaoRoutine']);

                if($insA->exe()===false){
                    msgError("Houve uma falha ao tentar cadastrar a rotina!".administrador.$idsa->getError(1));
                }else{
                    $page->s->s("action","modificar");
                    $page->s->s("idRoutine",$insA->getNewId());
                    msgSuccessRefresh(THIS,"Rotina cadastrada com sucesso!");
                }
            }else{
                $historico = $page->getHistoric($rowA['usuarioResponsavelRoutine'],$_POST['usuarioResponsavelRoutine'],"usuarioResponsavelRoutine",$historico,true);
                $historico = $page->getHistoric($rowA['descricaoRoutine'],$_POST['descricaoRoutine'],"descricaoRoutine",$historico,true);
                $historico = "DADOS QUE FORAM ALTERADOS: ".$historico;

                $updA = new iUpdate($idsa,"routine");
                $updA->where("idRoutine","=",$page->s->g("idRoutine"));
                $updA->set("dataModificacao",time());
                $updA->setHist("historico",$page->getHistText("M",$historico));
                $updA->set("usuarioResponsavelRoutine",$_POST['usuarioResponsavelRoutine']);
                $updA->set("descricaoRoutine",$_POST['descricaoRoutine']);

                if($updA->exe()===false){
                    msgError("Houve uma falha ao tentar cadastrar a rotina!");
                }else{
                    msgSuccessRefresh(THIS,"Rotina alterada com sucesso!");
                }
            }
        }

        $form = new iForm($corpo,"form");
        $form->unSetUppercase();

        $bp = new bootstrap($form,"bp");
        $bp->line();
        $bp->textBox($name = "idRoutine","ID","12,6,3,2,2");
        $bp->type($name,"id","tabelaRoutine");
        $bp->value($name,$page->getData($name,$rowA));

        $bp->textBox($name = "statusRoutine","Status","12,6,3,2,2");
        $bp->type($name,"status");

        $bp->textBox($name = "descricaoRoutine","Descrição","12,12,6,8,8");
        if($action=="cadastrar"){
            $bp->focus($name);
        }
        $bp->value($name,$page->getData($name,$rowA));

        # dados provisório
        $listaUsuario = array(
            "" => "Nenhum",
            1 => "Cleiton Cavalcanti",
            2 => "Denise Ramalho Cavalcanti",
            3 => "Matheus Ramalho Cavalcanti"
        );
        # fim - dados provisório

        $bp->comboBox($name = "usuarioResponsavelRoutine","Responsável","12,12,12,12,12");
        foreach($listaUsuario as $kA => $vA){
            $bp->optionComboBox($name,$kA,$vA);
        }
        $bp->value($name,$page->getData($name,$rowA));

        $bp->line(pularLinha);

        $bp->button($name = "salvar","Salvar","btn-success","12,3,3,2,2");
        $bp->java->setSubmitForm("click",$name,"form");

        $bp->button($name = "voltar","Voltar","btn-warning","12,3,3,2,2");
        $bp->java->setGoToPage("click",$name,THIS,"action","","","@".$PAGENAME);
    }
}

$page->End();