<div class="panel-body">
    <div class="row">
        <div class="btn-group col-md-6 text-center" data-toggle="buttons">Esta é uma oferta ... </div>
        <div class="btn-group col-md-6 text-center" data-toggle="buttons">Você vai vender um ... </div>
    </div>
    <div class="row">
        <div class="btn-group col-md-6" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="data[Offer][public]" value="INACTIVE" placeholder="Tipo de oferta" /> <span class="glyphicon glyphicon-screenshot"> Direcionada</span>
            </label> 
            <label class="btn btn-default">
                <input type="radio" name="data[Offer][public]" value="ACTIVE" placeholder="Tipo de oferta" /> <span class="glyphicon glyphicon-fullscreen"> Publica</span>
            </label> 
        </div>
        <div class="btn-group col-md-6" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="data[Offer][extra_infos][offer_type]" value="PRODUCT" placeholder="Vai vender um ..." /> <span class="glyphicon glyphicon-cd"> Produto</span>
            </label> 
            <label class="btn btn-default">
                <input type="radio" name="data[Offer][extra_infos][offer_type]" value="SERVICE" placeholder="Vai vender um ...?" /> <span class="glyphicon glyphicon-thumbs-up"> Serviço</span>
            </label> 
        </div>
    </div>    
    <div class="row">
        <div class="panel-body">
            <div class="form-group">
                <input name="data[Offer][title]" type="text" class="form-control require" id="" placeholder="Titulo da Oferta"  >
            </div>
            <div class="form-group">
                <textarea name="data[Offer][resume]" class="form-control require" placeholder="Resumo da oferta"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-body">

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
            <div class="form-inline">
                <div class="form-group marginTopSmall">
                    <input name="data[Offer][weight]" class="col-md-3 form-control require" type="text" placeholder="Peso Kg" />
                </div>
            </div>
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

            <div class="btn-group col-md-4 text-center" data-toggle="buttons">Esta oferta pode ser parcelada?</div>
            <div class="btn-group col-md-4 text-center" data-toggle="buttons">Incluir juros no parcelamento?</div>

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
        <div class="panel-body">
            <button type="submit" class="btn btn-success pull-right" id="saveProduct">Salvar</button>
        </div>
    </div>
</div>