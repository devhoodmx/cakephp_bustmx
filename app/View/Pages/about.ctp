<?php
$this->Package->assign('view', 'js', array(
	
));
$this->Package->assign('view', 'css', array(
	'view.pages.about'
));

// Page properties
$this->assign('title', __('page-title', __('Nosotros'), $config['App']['configurations']['website-title']));
// $this->assign('pageDescription', '');
$this->assign('navItemKey', 'home');
?>

<!-- sección mision vision -->
<section class="section-mission-vision bg-black">
    <div class="container">
        <div class="row head">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <img class="img-fluid img-circle-rings" src="/img/site/pages/about/green-circle-rings.png" alt="cirlce icon">
            </div>
            <div class="col-12">
                <p class="description text-pampas font-25 text-lg-center px-lg-5">
                    Somos una agencia de Marketing Digital establecida en México. Estamos enfocados en la
                    creación de estrategias funcionales y la entrega de resultados. Nuestro objetivo es ayudar a
                    las empresas a convertirse en casos de éxito; ya sea trabajando con startups o empresas
                    consolidadas, siempre ponemos toda nuestra experiencia a disposición de los
                    emprendedores y empresarios que quieren hacer crecer sus marcas.
                </p>
            </div>
        </div>

        <div class="row body align-items-center">
            <div class="col-12 col-scroll  d-none d-flex">
                <div class="scroll-line">
                    <img class="twenty-star d-none d-lg-block" src="/img/site/bust/twenty-pointed-star.png" alt="twenty-star">
                    <div class="green-circle d-none d-lg-block"></div>
                    <img class="five-star d-none d-lg-block" src="/img/site/pages/about/five-pointed-star.svg" alt="five-star">
              
                </div>
            </div>
            <div class="col-lg-4 col-text">
                <div class="text-white text-uppercase font-25 title text-center">
                    Misión
                </div>
                <p class="text-white font-25 text-center">
                    Existimos para inspirar y crear
                    ideas atrevidas que conectan
                    y conviertan.
                </p>
            </div>
            <div class="col-lg-4 col-images">
                <div class="container-title">
                    <div class="text-white text-uppercase font-25 title text-center">NOSOTROS</div>
                </div>
            </div>
            <div class="col-lg-4 col-text">
            <div class="text-white text-uppercase font-25 title text-center">
                    Visión
                </div>
                <p class="text-white font-25 text-center">
                    Establecer una comunidad de
                    marcas relevantes en más
                    ciudades.
                </p>
            </div>
        </div>

        <div class="row foot">
            <div class="col-lg-10 offset-lg-1">
               
              
                <?php 
                   
                  
                    $filename = $config['App']['configurations']['general-company-media'];
                    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                   

                    if(strtolower($fileExtension) == 'mp4'): ?>
                    <?php
                        $src = sprintf('/files/media/video/file_%s',$config['App']['configurations']['general-company-media']);
                    ?>
                    <video class="img-fluid w-100 about-media" src="<?=$src?>"  autoplay muted controls></video>
                <?php else: ?>
                    <?php 
                        $src = sprintf('/files/media/image/raw_%s',$config['App']['configurations']['general-company-media']);
                        echo $this->Html->Image(
                            $src,
                            [
                                'class' => 'img-fluid w-100 about-media'
                            ]
                        );
                    ?>
                <?php endif; ?>

               
            </div>
        </div>
    </div>
</section>

<section class="section-philosophy">
    <div class="container position-relative">
       <div class="title-section px-lg-5">
            <div class="container-title w-100 d-flex justify-content-start">
                <div class="title font-25 text-uppercase">
                    Declaración Bustilosófica
                </div>
            </div>
       </div>
       <div class="line-section">
            <img src="/img/site/pages/about/five-pointed-star.svg"  class="five-star filter-invert">

            <img src="/img/site/pages/about/five-pointed-star.svg"  class="five-star filter-invert star-animation">

            <div class="green-circle circle-animation"></div>

            <img src="/img/site/bust/twenty-pointed-star.png"  class="twenty-star filter-invert">
       </div>
    </div>
    <div class="container container-items d-flex flex-column">
          <!-- items -->
       <div class="row">
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="500">
                <div class="title text-uppercase">Somos originales</div>
                <p class="content">
                    Porque declaramos la guerra en
                    contra de lo convencional a través
                    de conceptos llamativos e ideas
                    descabelladas.
                </p>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="750">
                <div class="title text-uppercase">SOMOS AGRADECIDOS</div>
                <p class="content">
                Sí o sí, reconocemos el esfuerzo de
                nuestro trabajo, así como el trabajo
                de los demás.
                </p>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="1000">
                <div class="title text-uppercase">SOMOS HONESTOS</div>
                <p class="content">
                    Siempre actuaremos con sensatez
                    para tomar responsabilidad de
                    nuestras decisiones.
                </p>
            </div>
       </div>
       <div class="row">
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="1250">
                <div class="title text-uppercase">SOMOS RESPETUOSOS</div>
                <p class="content">
                    Somos considerados al desenvolver- nos dignamente con nosotros y conpersonas externas.
                </p>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="1500">
                <div class="title text-uppercase">SOMOS COLABORATIVOS</div>
                <p class="content">
                    Destacamos nuestra prudencia para
                    buscar soluciones adecuadas en
                    equipo ante cualquier situación.
                </p>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-duration="500"  data-aos-delay="1750">
                <div class="title text-uppercase">SOMOS CONSCIENTES</div>
                <p class="content">
                    Estaremos al tanto de nuestro entorno ex- terno e interno, sean clientes, compañeros
                    de trabajo o ambiente, para adaptarnos a
                    las diversas situaciones.
                </p>
            </div>
       </div>
    </div>
</section>