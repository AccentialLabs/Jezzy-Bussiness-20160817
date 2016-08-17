<!--CSS file to this page-->
<?php $this->Html->css('View/Product.add', array('inline' => false)); ?>
<!--Datetimepicker - library used on de date fild-->
<?php $this->Html->css('Library/Bootstrap/datepicker.min', array('inline' => false)); ?>
<?php $this->Html->css('Library/Bootstrap/datepicker3.min', array('inline' => false)); ?>
<?php $this->Html->script('Library/Bootstrap/bootstrap-datepicker.min', array('inline' => false)); ?>
<!--Summernote - library for the custom text used on description-->
<?php $this->Html->css('Library/Summernote/font-awesome/font-awesome.min', array('inline' => false)); ?>
<?php $this->Html->css('Library/Summernote/summernote', array('inline' => false)); ?>
<?php $this->Html->script('Library/Summernote/summernote.min', array('inline' => false)); ?>
<?php $this->Html->script('Library/Summernote/plugin/summernote-ext-hello', array('inline' => false)); ?>
<?php $this->Html->script('Library/Summernote/plugin/summernote-ext-hint', array('inline' => false)); ?>
<?php $this->Html->script('Library/Summernote/plugin/summernote-ext-video', array('inline' => false)); ?>
<!--Dropzone - library for the upload file-->
<?php $this->Html->css('Library/Dropzone/dropzone', array('inline' => false)); ?>
<?php $this->Html->script('Library/Dropzone/dropzone', array('inline' => false)); ?>
<!--JS util - library create for the project jezzy-->
<?php $this->Html->script('util', array('inline' => false)); ?>
<!--JS file to this page-->
<?php $this->Html->script('View/Product.add', array('inline' => false)); ?>

<h1 class="page-header">Adicionar Produtos/Ofertas</h1>
<form action="<?php echo $this->Html->url("/product/addProduct"); ?>" method="post" id="offerForm" enctype="multipart/form-data" accept-charset="utf-8" >
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <h4 class="panel-title">1 - Qual tipo de oferta voce vai cadastrar</h4>
                </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div class="row">
                        <div class="btn-group col-md-4 text-center" data-toggle="buttons">Esta é uma oferta ... </div>
                        <div class="btn-group col-md-4 text-center" data-toggle="buttons">Você vai vender um ... </div>
                    </div>
                    <div class="row">
                        <div class="btn-group col-md-4" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="data[Offer][public]" value="INACTIVE" placeholder="Tipo de oferta" /> <span class="glyphicon glyphicon-screenshot"> Direcionada</span>
                            </label> 
                            <label class="btn btn-default">
                                <input type="radio" name="data[Offer][public]" value="ACTIVE" placeholder="Tipo de oferta" /> <span class="glyphicon glyphicon-fullscreen"> Publica</span>
                            </label> 
                        </div>
                        <div class="btn-group col-md-4" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="radio" name="data[Offer][extra_infos][offer_type]" value="PRODUCT" placeholder="Vai vender um ..." /> <span class="glyphicon glyphicon-cd"> Produto</span>
                            </label> 
                            <label class="btn btn-default">
                                <input type="radio" name="data[Offer][extra_infos][offer_type]" value="SERVICE" placeholder="Vai vender um ...?" /> <span class="glyphicon glyphicon-thumbs-up"> Serviço</span>
                            </label> 
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <h4 class="panel-title">2 - Titulo e Resumo</h4>
                </a>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="form-group">
                        <input name="data[Offer][title]" type="text" class="form-control require" id="" placeholder="Titulo da Oferta"  >
                    </div>
                    <div class="form-group">
                        <textarea name="data[Offer][resume]" class="form-control require" placeholder="Resumo da oferta"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    <h4 class="panel-title">3 - Valores e parcelamento</h4>
                </a>
            </div>
            <div id="collapseThree" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div class="row marginLeftSmall">
                        <div class="form-inline">
                            <div class="form-group">
                                <input id="offer_value" name="data[Offer][value]" class="col-md-3 form-control require" type="text" placeholder="Preço Original" />
                            </div>
                            <div class="form-group">
                                <input id="offer_discounted_value" name="data[Offer][discounted_value]" class="col-md-3 form-control require" type="text" placeholder="Preço da Oferta" />
                            </div>
                            <div class="form-group">
                                <span id="percentage_discount">0</span> % de desconto
                            </div>
                            <input id="offer_percentage_discount" type="hidden" name="data[Offer][percentage_discount]" value="0"/>
                        </div>
                    </div>
                    <div class="row marginLeftSmall">
                        <div class="form-inline">
                            <div class="form-group marginTopSmall">
                                <input name="data[Offer][weight]" class="col-md-3 form-control require" type="text" placeholder="Peso Kg" />
                            </div>
                        </div>
                    </div>
                    <div class="row marginLeftSmall">
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="data[CompanyPreference][use_correios_api]" id="radioSenderMethod1" value="1" checked="">
                                    Correios
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="data[CompanyPreference][use_correios_api]" id="radioSenderMethod2" value="2">
                                    Transportadora
                                </label>
                                <div class="">
                                    <input name="data[Offer][extra_infos][delivery_dealine]" id="delivery_dealine" class="form-control marginAndSizeCustomTransport" type="text" placeholder="*Dias de Prazo" />
                                </div>
                                <div class="input">
                                    <input name="data[Offer][extra_infos][delivery_value]" id="delivery_value" class="form-control marginAndSizeCustomTransport" type="text" placeholder="*Valor frete" />
                                </div>
                            </div>
                            <p class="help-block">*campos preenchidos quando "Transportadora" for selecionado</p>
                        </div>
                    </div>
                    <div class="row marginLeftSmall">
                        <div class="btn-group col-md-4 text-center" data-toggle="buttons">Esta oferta pode ser parcelada?</div>
                        <div class="btn-group col-md-4 text-center" data-toggle="buttons">Incluir juros no parcelamento?</div>
                    </div>
                    <div class="row marginLeftSmall">
                        <div class="btn-group col-md-4 col-md-offset-1" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input name="data[Offer][parcels]" type="radio" name="paymentMonth" value="ACTIVE" /> <span> Sim</span>
                            </label> 
                            <label class="btn btn-default">
                                <input name="data[Offer][parcels]" type="radio" name="paymentMonth" value="INACTIVE" /> <span> Não</span>
                            </label> 
                        </div>
                        <div class="btn-group col-md-4" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input name="data[Offer][parcels_off_impost]" type="radio" name="includetax" value="1" /> <span> Sim</span>
                            </label> 
                            <label class="btn btn-default">
                                <input name="data[Offer][parcels_off_impost]" type="radio" name="includetax" value="2" /> <span> Não</span>
                            </label> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                    <h4 class="panel-title">4 - Descrição</h4>
                </a>
            </div>
            <div id="collapseFour" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div id="description" class="form-control"></div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    <h4 class="panel-title">5 - Especificações</h4>
                </a>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="panel-body">
                        <div id="specification" class="form-control"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    <h4 class="panel-title">6 - Opções do produto</h4>
                </a>
            </div>
            <div id="collapseSix" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <select name="data[Offer][extra_infos][category_id]" class="form-control">
                                    <option value='0'>Categoria</option>
                                    <?php
                                    var_dump($categorias);
                                    if (isset($categorias)) {
                                        foreach ($categorias as $cateroria) {
                                            echo '<option value="' . $cateroria['CompaniesCategory']['id'] . '">' . $cateroria['CompaniesCategory']['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="selectboxY" id="selectboxY" class="form-control">
                                    <option value="false">-- Atributo Y -- </option>
                                    <?php
                                    if (isset($atributos)) {
                                        foreach ($atributos as $atributo) {
                                            echo '<option id="" value="' . $atributo['offers_attributes']['id'] . '">' . $atributo['offers_attributes']['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="selectboxX" name="selectboxX" class="form-control">
                                    <option value="false">-- Atributo X -- </option>
                                    <?php
                                    if (isset($atributos)) {
                                        foreach ($atributos as $atributo) {
                                            echo '<option id="" value="' . $atributo['offers_attributes']['id'] . '">' . $atributo['offers_attributes']['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9" id="recebe">
                        <!-- Content load by ajax -->
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    <h4 class="panel-title">7 - Agendamento</h4>
                </a>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row"></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="date" >
                                        <div class="input-group input-append date" id="datePickerBegin">
                                            <input type="text" class="form-control" name="data[Offer][begins_at]" placeholder="Data Final" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="date" >
                                    <div class="input-group input-append date" id="datePickerEnd">
                                        <input type="text" class="form-control" name="data[Offer][ends_at]" placeholder="Data Final" />
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row marginTopSmall marginLeftSmall">Recorrência</div>
                        <div class="row">
                            <div class="col-md-3">
                                <select name="data[Offer][recorrencia]" id="recorencia" class="form-control marginTopSmall">
                                    <option value="0"> - - </option>
                                    <option value="1">1 mês </option>
                                    <option value="2">2 meses </option>
                                    <option value="3">3 meses </option>
                                    <option value="4">4 meses </option>
                                    <option value="5">5 meses </option>
                                    <option value="6">6 meses </option>
                                    <option value="7">7 meses </option>
                                    <option value="8">8 meses </option>
                                    <option value="9">9 meses </option>
                                    <option value="10">10 meses </option>
                                    <option value="11">11 meses </option>
                                    <option value="12">12 meses </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    <h4 class="panel-title">8 - Imagens</h4>
                </a>
            </div>
            <div id="collapseEight" class="panel-collapse collapse out">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <?php
                            if (isset($data['Offer']['photos_extra_one'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_one'], array('class' => 'imageSize', 'id' => 'principal-editimage'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image2.png", array('class' => 'imageSize', 'id' => 'principal-editimage'));
                            }
                            ?>
                            <input type="file" id="uper"  name="data[Offer][photo]" class="inputFileHide" value="" />
                        </div>
                        <div class="col-md-2 imageAlign">
                            <?php
                            if (isset($data['Offer']['photos_extra_zero'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_zero'], array('class' => 'imageSize', 'id' => 'editimage1'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image.png", array('class' => 'imageSize', 'id' => 'editimage1'));
                            }
                            ?>
                            <input type="file" id="uper1" name="data[Offer][photos_extra_zero]" class="inputFileHide" value=""/>

                        </div>
                        <div class="col-md-2 imageAlign">
                            <?php
                            if (isset($data['Offer']['photos_extra_one'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_one'], array('class' => 'imageSize', 'id' => 'editimage2'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image.png", array('class' => 'imageSize', 'id' => 'editimage2'));
                            }
                            ?>
                            <input type="file" id="uper2"  name="data[Offer][photos_extra_one]" class="inputFileHide" value="" />
                        </div>
                        <div class="col-md-2">
                            <?php
                            if (isset($data['Offer']['photos_extra_one'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_two'], array('class' => 'imageSize', 'id' => 'editimage3'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image.png", array('class' => 'imageSize', 'id' => 'editimage3'));
                            }
                            ?>
                            <input type="file" id="uper3"  name="data[Offer][photos_extra_two]" class="inputFileHide" value="" />
                        </div>
                        <div class="col-md-2">
                            <?php
                            if (isset($data['Offer']['photos_extra_one'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_three'], array('class' => 'imageSize', 'id' => 'editimage4'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image.png", array('class' => 'imageSize', 'id' => 'editimage4'));
                            }
                            ?>
                            <input type="file" id="uper4"  name="data[Offer][photos_extra_three]" class="inputFileHide"  value=""/>
                        </div>
                        <div class="col-md-2">
                            <?php
                            if (isset($data['Offer']['photos_extra_one'])) {
                                echo $this->Html->image($data['Offer']['photos_extra_four'], array('class' => 'imageSize', 'id' => 'editimage5'));
                            } else {
                                echo $this->Html->image("jezzy_icons/upload_image.png", array('class' => 'imageSize', 'id' => 'editimage5'));
                            }
                            ?>
                            <input type="file" id="uper5"  name="data[Offer][photos_extra_four]" class="inputFileHide" value=""/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseNane">
                    <h4 class="panel-title">9 - Oferta direcionada</h4>
                </a>
            </div>
            <div id="collapseEight" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
                        <?php
                        if(isset($offerFiltersData)){
                            echo "<pre>";
                            print_r($offerFiltersData);
                            echo "</pre>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <input type="hidden" name="data[Offer][id]" value="228" />
            <input type="hidden" id="gender" name="data[Offer][filters][gender]" />
            <input type="hidden" id="location" name="data[Offer][filters][location]"/>
            <input type="hidden" id="religion" name="data[Offer][filters][religion]"/>
            <input type="hidden" id="political" name="data[Offer][filters][political]"/>
            <input type="hidden" id="age_group" name="data[Offer][filters][age_group]"/>
            <input type="hidden" id="relationship_status" name="data[Offer][filters][relationship_status]" />
            <button type="submit" class="btn btn-success pull-right" id="saveProduct">Salvar</button>
        </div>
    </div>
</form>


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" >
            <div class="modal-header formModalError" >
                Foi encontrado um erro no fomulário.
            </div>
            <div class="modal-body" id="alertContent">

            </div>
        </div>
    </div>
</div>