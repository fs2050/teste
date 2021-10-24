
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
    //Apresentar ou ocultar o menu
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });

    //carregar aberto o submenu
    var active = $('.sidebar .active');
    if (active.length && active.parent('.collapse').length) {
        var parent = active.parent('.collapse');
        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }
});

$(document).ready(function () {
    $('#new_user').on("submit", function () {
        var password = $('#password').val();
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        } else if (password.length < 6 || password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, não deve ter número repetido!</div>");
            return false;
        } else if (password.length < 6 || !password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, deve ter pelo menos uma letra!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#send_login').on("submit", function () {
        if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        } else if ($('#password').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        }
    });
});

function passwordStrength() {
    var password = document.getElementById('password').value;
    var strength = 0;

    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }

    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    if ((password.length >= 8) && (password.match(/[@#$%&;*]+/))) {
        strength += 25;
    }

    if (password.match(/([1-9]+)\1{1,}/)) {
        strength += -25;
    }

    console.log(strength);
    viewStrength(strength);
}

function viewStrength(strength) {
    /*Imprimir a força da senha*/

    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = ("<div class='alert alert-danger mt-2' role='alert'>Senha Fraca</div>");
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = ("<div class='alert alert-warning mt-2' role='alert'>Senha Média</div>");
    } else if ((strength >= 50) && (strength < 70)) {
        document.getElementById("msgViewStrength").innerHTML = ("<div class='alert alert-info mt-2' role='alert'>Senha Boa</div>");
    } else if ((strength >= 70) && (strength < 100)) {
        document.getElementById("msgViewStrength").innerHTML = ("<div class='alert alert-success mt-2' role='alert'>Senha Forte</div>");
    }
}

$(document).ready(function () {
    $('#new_conf_email').on("submit", function () {
        if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        }
    });
});


$(document).ready(function () {
    $('#update_password').on("submit", function () {
        var password = $('#password').val();
        if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        } else if (password.length < 6 || password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, deve ter no minimo 6 caracteres e não deve ter número repetido!</div>");
            return false;
        } else if (password.length < 6 || !password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, deve ter pelo menos uma letra!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#add_user').on("submit", function () {
        var password = $('#password').val();
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        } else if (password === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        } else if (password.length < 6 || password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, não deve ter número repetido!</div>");
            return false;
        } else if (password.length < 6 || !password.match(/[A-Za-z]/)) {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Senha muito fraca, deve ter pelo menos uma letra!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_user').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        } else if ($('#adms_sits_user_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo situação!</div>");
            return false;
        } else if ($('#adms_access_level_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nível de acesso!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_perfil').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_img').on("submit", function () {
        if ($('#new_image').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem JPG ou PNG!</div>");
            return false;
        }
    });

    $('#new_image').change(function () {
        let validos = /(\.jpg|\.png)$/i;
        let fileInput = $(this);
        let name = fileInput.get(0).files["0"].name;
        if (validos.test(name)) {
            $(".msg").html('<p></p>');
            previewImage();
        } else {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem JPG ou PNG!</div>");
            return false;
        }
    });

    function previewImage() {
        var image = document.querySelector('input[name=new_image]').files[0];
        var preview = document.querySelector('#preview-img');

        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        };

        if (image) {
            reader.readAsDataURL(image);
        } else {
            preview.src = "";
        }
    }
});

$(document).ready(function () {
    $('#sits_user').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#adms_color_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo cor!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#form_color').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#color').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo cor!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#add_conf_email').on("submit", function () {
        if ($('#title').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo título!</div>");
            return false;
        } else if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if ($('#host').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo host!</div>");
            return false;
        } else if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        } else if ($('#password').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        } else if ($('#smtpsecure').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo SMTP!</div>");
            return false;
        } else if ($('#port').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo porta!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_conf_email').on("submit", function () {
        if ($('#title').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo título!</div>");
            return false;
        } else if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#email').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>");
            return false;
        } else if ($('#host').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo host!</div>");
            return false;
        } else if ($('#username').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo usuário!</div>");
            return false;
        } else if ($('#smtpsecure').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo SMTP!</div>");
            return false;
        } else if ($('#port').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo porta!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#edit_conf_email_pass').on("submit", function () {
        if ($('#password').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>");
            return false;
        }
    });
});

//Carregar modal apagar
$(document).ready(function () {
    $('a[data-confirm]').click(function () {
        var href = $(this).attr('href');

        if (!$('#confirm-delete').length) {
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" aria-labelledby="confirm-deleteLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger"><h5 class="modal-title text-white" id="deleteDataLabel">EXCLUIR REGISTRO</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja excluir o registro selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button><a class="btn btn-outline-danger" id="dataComfirmOk">Apagar</a></div></div></div></div>');
        }

        $('#dataComfirmOk').attr('href', href);
        $('#confirm-delete').modal({show: true});
        return false;
    });
});

$(document).ready(function () {
    $('#form_access_levels').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#sits_pages').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#adms_color_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo cor!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#groups_pages').on("submit", function () {
        if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#types_pages').on("submit", function () {
        if ($('#type').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo tipo!</div>");
            return false;
        } else if ($('#name').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        }
    });
});

$(document).ready(function () {
    $('#pages').on("submit", function () {
        if ($('#name_page').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>");
            return false;
        } else if ($('#controller').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo classe!</div>");
            return false;
        } else if ($('#metodo').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo metodo!</div>");
            return false;
        } else if ($('#menu_controller').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo classe no menu!</div>");
            return false;
        } else if ($('#menu_metodo').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo método no menu!</div>");
            return false;
        } else if ($('#publish').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo página pública!</div>");
            return false;
        } else if ($('#adms_sits_pgs_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo situação da página!</div>");
            return false;
        } else if ($('#adms_groups_pgs_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo grupo da página!</div>");
            return false;
        } else if ($('#adms_types_pgs_id').val() === "") {
            $(".msg").html("<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo tipo da página!</div>");
            return false;
        }
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function loadBtnSynchronize(){
    $("#btn-synchronize").html("<button class='btn btn-warning btn-sm' type='button' disabled><span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Sincronizado...</button>");
}

function loadLinkSynchronize(){
    $("#link-synchronize").html("<span class='dropdown-item'>Sincronizado...</span>");
}