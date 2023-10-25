<!-- Layout container -->
<div class="layout-page">
    <?php echo view('Admin/AdminLeyout/AdminNavbar'); ?>

    <style>
        /*!
 * bsStepper v1.7.0 (https://github.com/Johann-S/bs-stepper)
 * Copyright 2018 - 2019 Johann-S <johann.servoire@gmail.com>
 * Licensed under MIT (https://github.com/Johann-S/bs-stepper/blob/master/LICENSE)
 */
.bs-stepper .step-trigger {
    display: -ms-inline-flexbox;
    display: inline-flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding: 20px;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.5;
    color: #6c757d;
    text-align: center;
    text-decoration: none;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: none;
    border-radius: .25rem;
    transition: background-color .15s ease-out,color .15s ease-out
}

.bs-stepper .step-trigger:not(:disabled):not(.disabled) {
    cursor: pointer
}

.bs-stepper .step-trigger:disabled,.bs-stepper .step-trigger.disabled {
    pointer-events: none;
    opacity: .65
}

.bs-stepper .step-trigger:focus {
    color: #007bff;
    outline: none
}

.bs-stepper .step-trigger:hover {
    text-decoration: none;
    background-color: rgba(0, 0, 0, 0.06)
}

@media(max-width: 520px) {
    .bs-stepper .step-trigger {
        -ms-flex-direction:column;
        flex-direction: column;
        padding: 10px
    }
}

.bs-stepper-label {
    display: inline-block;
    margin: .25rem
}

.bs-stepper-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center
}

@media(max-width: 520px) {
    .bs-stepper-header {
        margin:0 -10px;
        text-align: center
    }
}

.bs-stepper-line,.bs-stepper .line {
    -ms-flex: 1 0 32px;
    flex: 1 0 32px;
    min-width: 1px;
    min-height: 1px;
    margin: auto;
    background-color: rgba(0, 0, 0, 0.12)
}

@media(max-width: 400px) {
    .bs-stepper-line,.bs-stepper .line {
        -ms-flex-preferred-size:20px;
        flex-basis: 20px
    }
}

.bs-stepper-circle {
    display: -ms-inline-flexbox;
    display: inline-flex;
    -ms-flex-line-pack: center;
    align-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 2em;
    height: 2em;
    padding: .5em 0;
    margin: .25rem;
    line-height: 1em;
    color: #fff;
    background-color: #6c757d;
    border-radius: 1em
}

.active .bs-stepper-circle {
    background-color: #007bff
}

.bs-stepper-content {
    padding: 0 20px 20px
}

@media(max-width: 520px) {
    .bs-stepper-content {
        padding:0
    }
}

.bs-stepper.vertical {
    display: -ms-flexbox;
    display: flex
}

.bs-stepper.vertical .bs-stepper-header {
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-align: stretch;
    align-items: stretch;
    margin: 0
}

.bs-stepper.vertical .bs-stepper-pane,.bs-stepper.vertical .content {
    display: block
}

.bs-stepper.vertical .bs-stepper-pane:not(.fade),.bs-stepper.vertical .content:not(.fade) {
    display: block;
    visibility: hidden
}

.bs-stepper-pane:not(.fade),.bs-stepper .content:not(.fade) {
    display: none
}

.bs-stepper .content.fade,.bs-stepper-pane.fade {
    visibility: hidden;
    transition-duration: .3s;
    transition-property: opacity
}

.bs-stepper-pane.fade.active,.bs-stepper .content.fade.active {
    visibility: visible;
    opacity: 1
}

.bs-stepper-pane.active:not(.fade),.bs-stepper .content.active:not(.fade) {
    display: block;
    visibility: visible
}

.bs-stepper-pane.dstepper-block,.bs-stepper .content.dstepper-block {
    display: block
}

.bs-stepper:not(.vertical) .bs-stepper-pane.dstepper-none,.bs-stepper:not(.vertical) .content.dstepper-none {
    display: none
}

.vertical .bs-stepper-pane.fade.dstepper-none,.vertical .content.fade.dstepper-none {
    visibility: hidden
}

.bs-stepper {
    border-radius: .5rem
}

.bs-stepper .line {
    flex: 0;
    min-width: auto;
    min-height: auto;
    background-color: rgba(0,0,0,0);
    margin: 0
}

.bs-stepper .line i {
    font-size: 1.8rem
}

.bs-stepper .bs-stepper-header {
    padding: 1.185rem 1.125rem
}

.bs-stepper .bs-stepper-header .step .step-trigger {
    padding: 0 1rem;
    flex-wrap: nowrap;
    font-weight: 500
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
    margin: 0;
    max-width: 224px;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: start;
    display: inline-grid;
    font-weight: 500
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-title {
    font-size: .9375rem;
    line-height: 1;
    font-weight: 500
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-subtitle {
    margin-top: .2rem;
    font-size: .75rem;
    font-weight: normal
}

html:not([dir=rtl]) .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
    margin-left: .35rem
}

[dir=rtl] .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
    margin-right: .35rem
}

.bs-stepper .bs-stepper-header .step .step-trigger:hover {
    background-color: rgba(0,0,0,0)
}

html:not([dir=rtl]) .bs-stepper .bs-stepper-header .step:first-child .step-trigger {
    padding-left: 0
}

[dir=rtl] .bs-stepper .bs-stepper-header .step:first-child .step-trigger {
    padding-right: 0
}

html:not([dir=rtl]) .bs-stepper .bs-stepper-header .step:last-child .step-trigger {
    padding-right: 0
}

[dir=rtl] .bs-stepper .bs-stepper-header .step:last-child .step-trigger {
    padding-left: 0
}

.bs-stepper .bs-stepper-header .step .bs-stepper-circle {
    height: 2.5rem;
    width: 2.5rem;
    font-weight: 500;
    font-size: 1.125rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: .375rem
}

.bs-stepper .bs-stepper-content {
    padding: 1.5rem 1.5rem
}

.bs-stepper.vertical .bs-stepper-header {
    min-width: 18rem
}

.bs-stepper.vertical .bs-stepper-header .step .step-trigger {
    padding: .65rem 0
}

.bs-stepper.vertical .bs-stepper-header .step:first-child .step-trigger {
    padding-top: 0
}

.bs-stepper.vertical .bs-stepper-header .step:last-child .step-trigger {
    padding-bottom: 0
}

.bs-stepper.vertical .bs-stepper-content {
    width: 100%
}

.bs-stepper.vertical .bs-stepper-content .content:not(.active) {
    display: none
}

.bs-stepper.vertical.wizard-icons .step {
    text-align: center;
    padding: .75rem 0
}

.bs-stepper.wizard-icons .bs-stepper-header {
    justify-content: space-around
}

.bs-stepper.wizard-icons .bs-stepper-header .step-trigger {
    flex-direction: column
}

.bs-stepper.wizard-icons .bs-stepper-header .step-trigger .bs-stepper-icon svg {
    height: 3.5rem;
    width: 3.5rem;
    margin-bottom: .5rem
}

.bs-stepper.wizard-icons .bs-stepper-header .step-trigger .bs-stepper-icon i {
    font-size: 1.6rem
}

.bs-stepper.wizard-icons .bs-stepper-header .step-trigger .bs-stepper-label {
    font-weight: normal
}

.bs-stepper.wizard-icons .bs-stepper-header .step.active .bs-stepper-label {
    font-weight: 500
}

.bs-stepper.wizard-modern .bs-stepper-header {
    border-bottom: none !important
}

.bs-stepper.wizard-modern .bs-stepper-content {
    border-radius: .5rem
}

.bs-stepper.wizard-modern.vertical .bs-stepper-header {
    border-right: none !important
}

.light-style .bs-stepper {
    background-color: #fff
}

.light-style .bs-stepper:not(.wizard-modern) {
    box-shadow: 0 2px 6px 0 rgba(67,89,113,.12)
}

.light-style .bs-stepper .bs-stepper-header {
    border-bottom: 1px solid #d9dee3
}

.light-style .bs-stepper .bs-stepper-header .line {
    color: rgba(67,89,113,.4)
}

.light-style .bs-stepper .bs-stepper-header .line:before {
    background-color: rgba(67,89,113,.4)
}

.light-style .bs-stepper .bs-stepper-header .step:not(.active) .bs-stepper-circle {
    background-color: rgba(67,89,113,.16);
    color: #697a8d
}

.light-style .bs-stepper .bs-stepper-header .step .bs-stepper-subtitle {
    color: #a1acb8
}

.light-style .bs-stepper .step-trigger {
    color: #697a8d
}

.light-style .bs-stepper .step.crossed .bs-stepper-label {
    color: #a1acb8 !important
}

.light-style .bs-stepper.vertical .bs-stepper-header {
    border-bottom: none
}

@media(max-width: 991.98px) {
    .light-style .bs-stepper.vertical .bs-stepper-header {
        border-right:none !important;
        border-left: none !important;
        border-bottom: 1px solid #d9dee3
    }
}

.light-style .bs-stepper.wizard-modern {
    background-color: rgba(0,0,0,0)
}

.light-style .bs-stepper.wizard-modern .bs-stepper-content {
    background-color: #fff;
    box-shadow: 0 2px 6px 0 rgba(67,89,113,.12)
}

.light-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-icon svg {
    fill: #697a8d
}

[dir=rtl].light-style .bs-stepper.vertical .bs-stepper-header {
    border-left: 1px solid #d9dee3
}

html:not([dir=rtl]).light-style .bs-stepper.vertical .bs-stepper-header {
    border-right: 1px solid #d9dee3
}

.dark-style .bs-stepper {
    background-color: #2b2c40
}

.dark-style .bs-stepper:not(.wizard-modern) {
    box-shadow: 0 .125rem .5rem 0 rgba(0,0,0,.16)
}

.dark-style .bs-stepper .bs-stepper-header {
    border-bottom: 1px solid #444564
}

.dark-style .bs-stepper .bs-stepper-header .bs-stepper-label {
    color: #a3a4cc
}

.dark-style .bs-stepper .bs-stepper-header .line {
    color: #a3a4cc
}

.dark-style .bs-stepper .bs-stepper-header .line:before {
    background-color: #2b2c40
}

.dark-style .bs-stepper .bs-stepper-header .step:not(.active) .bs-stepper-circle {
    background-color: rgba(124,125,182,.16);
    color: #a3a4cc
}

.dark-style .bs-stepper .step-trigger {
    color: #a3a4cc
}

.dark-style .bs-stepper .step.crossed .bs-stepper-label {
    color: #7071a4 !important
}

.dark-style .bs-stepper .step .bs-stepper-subtitle {
    color: #7071a4
}

.dark-style .bs-stepper.vertical .bs-stepper-header {
    border-bottom: none
}

@media(max-width: 991.98px) {
    .dark-style .bs-stepper.vertical .bs-stepper-header {
        border-right:none !important;
        border-left: none !important;
        border-bottom: 1px solid #444564
    }
}

.dark-style .bs-stepper.wizard-modern {
    background-color: rgba(0,0,0,0)
}

.dark-style .bs-stepper.wizard-modern .bs-stepper-content {
    background-color: #2b2c40;
    box-shadow: 0 .125rem .5rem 0 rgba(0,0,0,.16)
}

.dark-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-icon i {
    color: #a3a4cc
}

.dark-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-icon svg {
    fill: #a3a4cc
}

.dark-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-label {
    color: #a3a4cc
}

[dir=rtl].dark-style .bs-stepper.vertical .bs-stepper-header {
    border-left: 1px solid #444564
}

html:not([dir=rtl]).dark-style .bs-stepper.vertical .bs-stepper-header {
    border-right: 1px solid #444564
}

[dir=rtl] .bs-stepper .bs-stepper-content .btn-next i,[dir=rtl] .bs-stepper .bs-stepper-content .btn-prev i {
    transform: rotate(180deg);
    line-height: 1.05;
    margin-bottom: 1.5px
}

[dir=rtl] .bs-stepper.wizard-modern.vertical .bs-stepper-header {
    border-left: none !important
}

@media(min-width: 992px) {
    [dir=rtl] .bs-stepper .bs-stepper-header .line i {
        transform:rotate(180deg)
    }
}

@media(max-width: 991.98px) {
    [dir=rtl] .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
        margin-left:0;
        margin-right: .35rem
    }
}

@media(max-width: 991.98px) {
    .bs-stepper .bs-stepper-header {
        flex-direction:column;
        align-items: flex-start
    }

    .bs-stepper .bs-stepper-header .step .step-trigger {
        padding: .5rem 0;
        flex-direction: row
    }

    .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
        margin-left: .35rem
    }

    .bs-stepper .bs-stepper-header .step:first-child .step-trigger {
        padding-top: 0
    }

    .bs-stepper .bs-stepper-header .step:last-child .step-trigger {
        padding-bottom: 0
    }

    .bs-stepper.vertical {
        flex-direction: column
    }

    .bs-stepper.vertical .bs-stepper-header {
        align-items: flex-start
    }

    .bs-stepper:not(.vertical) .bs-stepper-header .line i {
        display: none
    }

    .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-icon svg {
        margin-top: .5rem
    }
}

@media(max-width: 520px) {
    .bs-stepper-header {
        margin:0
    }
}

#wizard-create-app.vertical .bs-stepper-header {
    min-width: 15rem
}

    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <div class="card">
                <div class="card-header d-flex justify-content-between flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0"><?=$title;?></h5>
                    </div>
                </div>
            </div>

            <div class="bs-stepper vertical wizard-modern wizard-modern-vertical mt-2">
                <div class="bs-stepper-header">
                    <div class="step crossed" data-target="#account-details-modern-vertical">
                        <button type="button" class="step-trigger" aria-selected="false">
                            <span class="bs-stepper-circle">1</span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Account Details</span>
                                <span class="bs-stepper-subtitle">Setup Account Details</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step crossed" data-target="#personal-info-modern-vertical">
                        <button type="button" class="step-trigger" aria-selected="false">
                            <span class="bs-stepper-circle">2</span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Personal Info</span>
                                <span class="bs-stepper-subtitle">Add personal info</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step active" data-target="#social-links-modern-vertical">
                        <button type="button" class="step-trigger" aria-selected="true">
                            <span class="bs-stepper-circle">3</span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Social Links</span>
                                <span class="bs-stepper-subtitle">Add social links</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form onsubmit="return false">
                        <!-- Account Details -->
                        <div id="account-details-modern-vertical" class="content dstepper-block">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Account Details</h6>
                                <small>Enter Your Account Details.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="username-modern-vertical">Username</label>
                                    <input type="text" id="username-modern-vertical" class="form-control"
                                        placeholder="johndoe">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="email-modern-vertical">Email</label>
                                    <input type="email" id="email-modern-vertical" class="form-control"
                                        placeholder="john.doe@email.com" aria-label="john.doe">
                                </div>
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="password-modern-vertical">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password-modern-vertical" class="form-control"
                                            placeholder="············" aria-describedby="password2-modern-vertical">
                                        <span class="input-group-text cursor-pointer" id="password2-modern-vertical"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="confirm-password-modern-vertical">Confirm
                                        Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="confirm-password-modern-vertical"
                                            class="form-control" placeholder="············"
                                            aria-describedby="confirm-password-modern-vertical2">
                                        <span class="input-group-text cursor-pointer"
                                            id="confirm-password-modern-vertical2"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" disabled="">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Info -->
                        <div id="personal-info-modern-vertical" class="content dstepper-block">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Personal Info</h6>
                                <small>Enter Your Personal Info.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="first-name-modern-vertical">First Name</label>
                                    <input type="text" id="first-name-modern-vertical" class="form-control"
                                        placeholder="John">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="last-name-modern-vertical">Last Name</label>
                                    <input type="text" id="last-name-modern-vertical" class="form-control"
                                        placeholder="Doe">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="country-modern-vertical">Country</label>
                                    <div class="position-relative">
                                        <div class="position-relative"><select class="select2 select2-hidden-accessible"
                                                id="country-modern-vertical" tabindex="-1" aria-hidden="true"
                                                data-select2-id="country-modern-vertical">
                                                <option label=" " data-select2-id="54"></option>
                                                <option>UK</option>
                                                <option>USA</option>
                                                <option>Spain</option>
                                                <option>France</option>
                                                <option>Italy</option>
                                                <option>Australia</option>
                                            </select><span class="select2 select2-container select2-container--default"
                                                dir="ltr" data-select2-id="53" style="width: auto;"><span
                                                    class="selection"><span
                                                        class="select2-selection select2-selection--single"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-country-modern-vertical-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-country-modern-vertical-container"
                                                            role="textbox" aria-readonly="true"><span
                                                                class="select2-selection__placeholder">Select
                                                                value</span></span><span
                                                            class="select2-selection__arrow" role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="language-modern-vertical">Language</label>
                                    <div class="dropdown bootstrap-select show-tick w-auto"><select
                                            class="selectpicker w-auto" id="language-modern-vertical"
                                            data-style="btn-transparent" data-icon-base="bx"
                                            data-tick-icon="bx-check text-white" multiple="">
                                            <option>English</option>
                                            <option>French</option>
                                            <option>Spanish</option>
                                        </select><button type="button" tabindex="-1"
                                            class="btn dropdown-toggle bs-placeholder btn-transparent"
                                            data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-5"
                                            aria-haspopup="listbox" aria-expanded="false" title="Nothing selected"
                                            data-id="language-modern-vertical">
                                            <div class="filter-option">
                                                <div class="filter-option-inner">
                                                    <div class="filter-option-inner-inner">Nothing selected</div>
                                                </div>
                                            </div>
                                        </button>
                                        <div class="dropdown-menu ">
                                            <div class="inner show" role="listbox" id="bs-select-5" tabindex="-1"
                                                aria-multiselectable="true">
                                                <ul class="dropdown-menu inner show" role="presentation"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Social Links -->
                        <div id="social-links-modern-vertical" class="content active dstepper-block">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Social Links</h6>
                                <small>Enter Your Social Links.</small>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="twitter-modern-vertical">Twitter</label>
                                    <input type="text" id="twitter-modern-vertical" class="form-control"
                                        placeholder="https://twitter.com/abc">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="facebook-modern-vertical">Facebook</label>
                                    <input type="text" id="facebook-modern-vertical" class="form-control"
                                        placeholder="https://facebook.com/abc">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="google-modern-vertical">Google+</label>
                                    <input type="text" id="google-modern-vertical" class="form-control"
                                        placeholder="https://plus.google.com/abc">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="linkedin-modern-vertical">LinkedIn</label>
                                    <input type="text" id="linkedin-modern-vertical" class="form-control"
                                        placeholder="https://linkedin.com/abc">
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>



        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->