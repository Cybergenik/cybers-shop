function checker(){
    p = document.getElementById("pass").value;
    v = document.getElementById("vpass").value;
    const reg_pass = RegExp('^(?=.*[0-9]).{8,}$');
    if(reg_pass.test(p)){
        document.getElementById("pass_war").setAttribute("hidden", null);
        if(p !== "" && v !== ""){
            document.getElementById("pass_war").setAttribute("hidden", null);
            if(p == v){
                document.getElementById("pass").style.borderColor = "green";
                document.getElementById("vpass").style.borderColor = "green";
                document.getElementById("warning").setAttribute("hidden", null);
                document.getElementById("submit").removeAttribute("disabled");
            }
            else if(p != v){
                document.getElementById("pass").style.borderColor = "red";
                document.getElementById("vpass").style.borderColor = "red";
                document.getElementById("warning").removeAttribute("hidden");
                document.getElementById("submit").setAttribute("disabled", true);
            }
        }
    }
    else{
        document.getElementById("warning").setAttribute("hidden", null);
        document.getElementById("pass_war").removeAttribute("hidden");
    }
}

function reset_form(){
    document.getElementById("pass").style.borderColor = "";
    document.getElementById("vpass").style.borderColor = "";
    document.getElementById("warning").setAttribute("hidden", null);
    document.getElementById("submit").removeAttribute("disabled");
    document.getElementById("pass_war").setAttribute("hidden", null);
}
