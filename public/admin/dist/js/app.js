
$(document).ready(function(){
setTimeout(function() { $('.alert').alert('close'); }, 5000);
});

$(document).on("input", ".only_numbers", function() {
    this.value = this.value.replace(/\D/g,'');
});

