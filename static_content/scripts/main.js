let login_window= document.getElementById('login_window');
let expences_window= document.getElementById('expences_window');
let add_data_window= document.getElementById('add_data_window');


window.addEventListener('load', () => {
    login_window.style.display="none";
    expences_window.style.display="none";
    add_data_window.style.display="none";
    
    render_window();

    hide_loading();
}, false);



function render_expences_window() {
    login_window.style.display="none";
    expences_window.style.display="block";
    add_data_window.style.display="none";
    
    ssid= parseInt(getCookie("ssid"));
    fetch(rest_endpoint+"fetch_data.php?ssid="+ssid+"&thread=current")
    .then(res => res.json())
    .then(res => {
        if(res.success == 'true') {
            let d= make_table_with_data(res.data);
            document.getElementById("expences_list").innerHTML= d;
        }
        else {
            show_error("getting data unsuccessful! Try re-login");
            console.error(res);
        }
    })
    .catch(err =>  {
        show_error("Unable to fetch data!");
        console.error(err);
    })
}



function render_login_window() {
    login_window.style.display="block";
    expences_window.style.display="none";
    add_data_window.style.display="none";
}


function render_window() {
    try {
        ssid= parseInt(getCookie("ssid"));
        if( !Number.isInteger(ssid) || ssid<1) {
            throw("ssid not set");
        }
    
        render_expences_window();
    } catch(err) {
        render_login_window();
    }
}

