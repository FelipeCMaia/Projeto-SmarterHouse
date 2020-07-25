<?php 
class Component{
 

  function Header_modulos(){
    echo ' <!--HEADER OF SITE-->
    <div class="cell medium-3 large-3 auto div_primaria_header show-for-small-only" >
      <div class="cell shrink header">
  
        <div class="title-bar bg_dark" data-responsive-toggle="example-menu" data-hide-for="medium"  
        data-aos-duration="1200">
          <button class="menu-icon" type="button" data-toggle="example-menu"></button>
          <div class="title-bar-title color_text_light" >Menu</div>
        </div>
  
        <div class="top-bar bg_dark" id="example-menu">
          <div class="top-bar-left bg_dark" >
            <ul class="dropdown menu bg_dark"  data-aos-duration="1000" data-dropdown-menu style>
              <li class="menu-text color_text_light" >Smarterhouse</li>
              <li class="bg_dark">
                <a href="../paginas/pagina_usuario" class="color_text_light">Página do Usuario</a>
              </li>
              <li><a href="../paginas/download"class="color_text_light " >Baixar Aplicativo</a></li>
              <li><a href="../paginas/contato"class="color_text_light">Fale Conosco</a></li>
              
            </ul>
          </div>
          <div class="top-bar-right bg_dark">
            <ul class="menu bg_dark">
               <a href="../action/sair" class="color_text_light" >login/logout</a>
            </ul>
          </div>
        </div>
  
      </div>
    </div>
    <!--END OF HEADER-->
  ';
}

    function Header(){
        echo ' <!--HEADER OF SITE-->
        <div class="cell medium-3 large-3 auto div_primaria_header" >
          <div class="cell shrink header">
      
            <div class="title-bar bg_dark" data-responsive-toggle="example-menu" data-hide-for="medium"  
            data-aos-duration="1200">
              <button class="menu-icon" type="button" data-toggle="example-menu"></button>
              <div class="title-bar-title color_text_light" >Menu</div>
            </div>
      
            <div class="top-bar bg_dark" id="example-menu">
              <div class="top-bar-left bg_dark" >
                <ul class="dropdown menu bg_dark"  data-aos-duration="1000" data-dropdown-menu style>
                  <li class=" color_text_light" ><a href="../index" class="color_text_light" style="font-size: larger; line-height: 50px;" >Smarterhouse</a></li>
                  <li class="bg_dark">
                    <a href="../paginas/pagina_usuario" class="color_text_light" style="font-size: medium; line-height: 50px;" >Página do Usuario</a>
     
                  </li>
                  <li><a href="../paginas/download"class="color_text_light" style="font-size: medium; line-height: 50px;" >Baixar Aplicativo</a></li>
                  <li><a href="../paginas/contato"class="color_text_light" style="font-size: medium; line-height: 50px;" >Fale Conosco</a></li>
                 
                </ul>
              </div>
              <div class="top-bar-right bg_dark">
                <ul class="menu bg_dark">
                   <a href="../action/sair" class="color_text_light" style="font-size: medium; line-height: 50px;"  >login/logout</a>
                </ul>
              </div>
            </div>
      
          </div>
        </div>
        <!--END OF HEADER-->
      ';
    }
    
    function HeaderIndex(){
      echo ' <!--HEADER OF SITE-->
      <div class="cell medium-3 large-3 auto div_primaria_header" >
        <div class="cell shrink header">
    
          <div class="title-bar bg_dark" data-responsive-toggle="example-menu" data-hide-for="medium"  
          data-aos-duration="1200">
            <button class="menu-icon" type="button" data-toggle="example-menu"></button>
            <div class="title-bar-title color_text_light" >Menu</div>
          </div>
    
          <div class="top-bar bg_dark" id="example-menu">
            <div class="top-bar-left bg_dark" >
              <ul class="dropdown menu bg_dark"  data-aos-duration="1000" data-dropdown-menu style>
                <li class=" color_text_light" ><a href="index" class="color_text_light" style="font-size: larger; line-height: 50px;" >Smarterhouse</a></li>
                <li class="bg_dark">
                  <a href="paginas/pagina_usuario" class="color_text_light" style="font-size: medium; line-height: 50px;" >Página do Usuario</a>
                  
                </li>
                <li><a href="paginas/download"class="color_text_light" style="font-size: medium; line-height: 50px;" >Baixar Aplicativo</a></li>
                <li><a href="paginas/contato"class="color_text_light" style="font-size: medium; line-height: 50px;" >Fale Conosco</a></li>
               
              </ul>
            </div>
            <div class="top-bar-right bg_dark">
              <ul class="menu bg_dark">
                 <a href="action/sair" class="color_text_light" style="font-size: medium; line-height: 50px;"  >login/logout</a>
              </ul>
            </div>
          </div>
    
        </div>
      </div>
      <!--END OF HEADER-->
    ';
  }
  

    function Footer(){
        echo '<!-- HERE IS THE FOOTER -->
       
        <div class="cell medium-12 large-12 div_primaria_footer" >
          <div class="grid-x grid-padding-x"
          >
            <div class="medium-2 large-2"></div>
      
            <div class="grid-x grid-padding-x medium-8 large-8">
      
            <div class="medium-3  large-3 offset-1 small-6 cell " data-aos="fade-right"
              data-aos-anchor-placement="bottom-bottom" >
              <p><a class="cor_branca" href="#">WEBLY THEMES</a></p>
              <p><a class="cor_branca" href="#">PRE-SALE FAOS</a></p>
              <p><a class="cor_branca" href="#">SUBMIT A TICKET</a></p><br>
            </div>
      
            <div class="medium-3 large-3 small-6 cell "data-aos="fade-up"
              data-aos-anchor-placement="bottom-bottom">
              <p><a class="cor_branca" href="#">SERVICES</a></p>
              <p><a class="cor_branca" href="#">THEME TWEAK</a></p><br>
            </div>
      
            <div class="medium-3 large-3 small-6 cell"data-aos="fade-down"
              data-aos-anchor-placement="bottom-bottom">
              <p><a class="cor_branca" href="#">SHOWCASE</a></p>
              <p><a class="cor_branca" href="#">WIDGETKIT</a></p>
              <p><a class="cor_branca" href="#">SUPPORT</a></p><br>
            </div>
      
            <div class="medium-3 large-3 small-6 cell"  data-aos="fade-right"
              data-aos-anchor-placement="bottom-bottom">
              <p><a class="cor_branca" href="#">ABOUT US</a></p>
              <p><a class="cor_branca" href="#">CONTACT US</a></p>
              <p><a class="cor_branca" href="#">AFFILIATES</a></p>
              <p><a class="cor_branca" href="#">RESOURCES</a></p><br>
            </div>
      
            <div class="medium-12 large-12 cell color_text_light" data-aos="fade-down"
              data-aos-anchor-placement="bottom-bottom">
              <hr class="linha_horizontal">
            </div>
            <div class="medium-2 large-2"></div>
          </div>
      
      
            <div class="medium-12 large-12 cell div_btn_social"             
              data-aos="fade-down" data-aos-anchor-placement="bottom-bottom">
              <button class="  button secondary hollow btn_social"> <i
                  class="fi-social-facebook icone_social" ></i></button>
              <button class=" button secondary hollow btn_social"> <i
                  class="fi-social-instagram icone_social"></i></button>
              <button class=" button secondary hollow btn_social"> <i
                  class="fi-social-reddit icone_social" ></i></button>
              <button class=" button secondary hollow btn_social"> <i
                  class="fi-social-twitter icone_social" ></i></button>
              <button class=" button secondary hollow btn_social"> <i
                  class="fi-social-google-plus icone_social" ></i></button>
              <button class=" button secondary hollow btn_social"> <i
                  class="fi-social-windows icone_social"></i></button>
            </div>
            <div class="medium-12 large-12 small-12 cell div_copyrights" data-aos="fade-left" 
            data-aos-anchor-placement="bottom-bottom">©Copyrights All
              rights reserveds</div>
      
      
          </div>
      
        </div>
        <!-- END OF FOOTER -->';
    }

  }
