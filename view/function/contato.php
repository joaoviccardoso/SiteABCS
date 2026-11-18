<div class="container cta" id='pagina'>
  <h1>Fale conosco!</h1>
  <div class="row justify-content-lg-center">
    <form class="well form-horizontal col-md-6" action="./contatoRealizado" method="post" id="contact_form">
      <fieldset>
        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-user"></i>
              </span>
              <input name="nome" placeholder="Nome Completo" class="form-control" type="text" required="required">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-envelope"></i>
              </span>
              <input name="email" placeholder="E-Mail" class="form-control" type="email" required="required">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-phone-square"></i>
              </span>
              <input name="telefone" maxlength="15" pattern="[0-9]{8,15}$" placeholder="(99)91234-5678" class="form-control" type="tel"
                required="required">
            </div>
          </div>
        </div>

        <!-- Text input-->

        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
              </span>
              <input name="endereco" placeholder="Endereço" class="form-control" type="text" required="required">
            </div>
          </div>
        </div>

        <!-- Text input-->

        <div class="form-group ">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-map"></i>
              </span>
              <input name="cidade" placeholder="Cidade" class="form-control" type="text" required="required">
            </div>
          </div>
        </div>

        <!-- Select Basic -->

        <div class="form-group">
          <div class="selectContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-map-signs"></i>
              </span>
              <select name="estado" class="form-control selectpicker" required="required">
                <option value="">Selecione seu estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Text input-->

        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-home"></i>
              </span>
              <input name="cep" placeholder="CEP" class="form-control" type="text" required="required">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-comment"></i>
              </span>
              <input name="assunto" placeholder="Assunto" <?php echo $this->assunto(); ?> class="form-control" type="text" required="required">
            </div>
          </div>
        </div>


        <div class="form-group">
          <div class=" inputGroupContainer">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square"></i>
              </span>
              <textarea class="form-control" name="mensagem" placeholder="Mensagem" required="required"></textarea>
            </div>
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label"></label>
          <button type="submit" class="btn btn-info">Enviar
            <span class="fa fa-paper-plane"></span>
          </button>
        </div>

      </fieldset>
    </form>
    <div class="col-md-6">
      <div class="form-area text-center">
        <br style="clear:both">
        <h3 style="margin-bottom: 25px; text-align: center;">ABCS Informática</h3>
        <h5>contato@abcsinformatica.com.br</h5>
        <h5>(19)3866-1100</h5>
        <div class='mapa' id='mapa'>
          <iframe style="border:0" src="https://www.google.com/maps/embed/v1/place?q=http%3A%2F%2Fwww.abcsinformatica.com.br%2F&key=AIzaSyAcXdwgVCf4R4q792aiSGm7_RifpEDVKos"
            allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>