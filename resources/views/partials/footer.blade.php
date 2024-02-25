<?php
$specialties = ['Dermatologo-venereologo', 'Ginecologo', 'Oculista', 'Otorinolaringoiatra', 'Ortopedico-traumatologo', 'Cardiologo', 'Andrologo', 'Urologo', 'Neurologo', 'Neurochirurgo', 'Dentista', 'Pediatra', 'Osteopata', 'Fisiatra', 'Psicologo', 'Medico di medicina generale', 'Gastroenterologo', 'Medico estetico', 'Allergologo-immunologo', 'Fisioterapista', 'Chirurgo plastico', 'Endocrinologo', 'Geriatra', 'Ematologo', 'Reumatologo', 'Nefrologo', 'Radiologo', 'Anestesista', 'Immunologo', 'Patologo'];
//dd($specialties);
?>
<footer class="py-5">
    <div class="top-footer container py-3 mb-2">
        <div class="row justify-content-between">
            <div class="col-8 d-flex gap-5">
                <div class="d-flex flex-column">
                    <h3 class="">Servizi</h3>
                    <ul>
                        <li><a href="#">Chi Siamo</a></li>
                        <li><a href="#">Contatti</a></li>
                        <li><a href="#">Lavora con noi</a></li>
                        <li><a href="#">Ufficio Stampa</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Trova il tuo medico</h3>
                    <div class="d-flex justify-content-between gap-5">
                        <div class="d-flex flex-column">
                            <ul>
                                @foreach (array_slice($specialties, 0, 6) as $specialty)
                                    <li>
                                        <a href="#">{{ $specialty }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="d-flex flex-column">
                            <ul>
                                @foreach (array_slice($specialties, 6, 6) as $specialty2)
                                    <li>
                                        <a href="#">{{ $specialty2 }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-flex flex-column">
                            <ul>
                                @foreach (array_slice($specialties, 12, 6) as $specialty3)
                                    <li>
                                        <a href="#">{{ $specialty3 }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 d-flex flex-column align-items-center">
                <div class="logo-wrapper">
                    <img class="footer-logo border-rounded"
                        src="{{ asset('storage' . '\/images/OIG2.kc86IYLpVtKY.jpg') }}" alt="logo">
                </div>
                <div class="info-brand mt-3">
                    <span class="d-block"><em>Viale del Policlinico, 155</em></span>
                    <span><em>00196 Roma (RM), Italia</em></span>
                </div>
                <div class="d-flex mt-2 gap-3 social-icons">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-linkedin"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer col-12 text-center py-3">
        <p class="footer-text">©2024 BDoctors. All rights reserved.</p>
    </div>
</footer>
