

document.getElementById("logout").addEventListener('click', e => {

    if(!confirm("Confirm LogOut?")) {
        return;
    }
    show_loading();

    ssid= parseInt(getCookie("ssid"));
    fetch(rest_endpoint+"logout.php?ssid="+ssid)
    .then(res => res.json())
    .then(res => {
            setCookie('ssid', "");
            render_window();
    })
    .catch(err => {
        show_error("Unable to logout!");
        console.error(err);
    })
    .finally(() => {
        hide_loading();
    })
    
}, false);




document.getElementById("login").addEventListener('click', e => {
    show_loading();

    fetch(rest_endpoint+"login.php?"+ new URLSearchParams({
        user: document.getElementById("username_field").value,
        pass: document.getElementById("password_field").value,
    }))
    .then(res => res.json())
    .then(res => {
            if(res.success == 'true') {
                let ssid= res.key;
                setCookie('ssid', ssid);
                render_window();
            }
            else {
                show_error("Invalid username/password!");
            }

            document.getElementById("username_field").value= "";
            document.getElementById("password_field").value= "";
    })
    .catch(err => {
        show_error("Unable to login!");
        console.error(err);
    })
    .finally(() => {
        hide_loading();
    })
    
}, false);



document.getElementById("sign-up").addEventListener('click', e => {

    show_loading();

    fetch(rest_endpoint+"create_user.php?"+ new URLSearchParams({
        user: document.getElementById("username_field").value,
        pass: document.getElementById("password_field").value,
    }))
    .then(res => res.json())
    .then(res => {
            if(res.success == 'true') {
                render_window();
                show_warning("Signup Success. Please Login now.");
            }
            else {
                show_error("Username/password in Invalid!");
            }

            document.getElementById("username_field").value= "";
            document.getElementById("password_field").value= "";
    })
    .catch(err => {
        show_error("Unable to Sign Up!");
        console.error(err);
    })
    .finally(() => {
        hide_loading();
    })
    
}, false);



document.getElementById("show_add_data_window").addEventListener("click", e => {
    e.preventDefault();
    // add_data_window.style.display="block";
    show_add_data_window();
}, false)


document.getElementById("close_add_data").addEventListener("click", e => {
    e.preventDefault();
    // add_data_window.style.display="none";
    hide_add_data_window();
}, false)




document.getElementById("submit_add_data").addEventListener('click', e => {
    e.preventDefault();
    ssid= parseInt(getCookie("ssid"));
    if( !Number.isInteger(ssid) || ssid<1) {
        setCookie("ssid", "");
        render_window();
        return;
    }

    if(document.getElementById("insert_item").value.length <1
    || document.getElementById("insert_value").value.length<1
    || document.getElementById("expence_type").value.length<1) {
        show_warning("Fill up the data!");
        return;
    }

    let fetch_url= rest_endpoint+"insert_data.php?"+ new URLSearchParams({
        ssid: ssid,
        item: document.getElementById("insert_item").value,
        cost: document.getElementById("insert_value").value,
        expence_type: document.getElementById("expence_type").value,
    });

    if(document.getElementById("start_new_thread").checked) {
        fetch_url+="&"+new URLSearchParams({
            new_thread: true,
        });
    }

    let dt=document.getElementById("insert_time").value;
    if(dt.length>1) {
        let d= new Date(dt);
        fetch_url+="&"+new URLSearchParams({
            timestamp: parseInt(d.getTime()/1000),
        })
    }

    show_loading();

    fetch(fetch_url)
    .then(res => res.json())
    .then(res => {
        if(res.success == 'true') {
            show_warning("Insertion Success");
            hide_add_data_window();
            render_window();
        }
        else {
            show_error("Could not insert!");
        }
    })
    .catch(err => {
        show_error("Could not insert! err in Connection!");
        console.error(err);
    })
    .finally(() => {
        document.getElementById("insert_time").value= "";
        document.getElementById("insert_item").value= "";
        document.getElementById("insert_value").value= "";
        document.getElementById("expence_type").value= "1";
        hide_loading();
    })

}, false);




document.getElementById("filter_button").addEventListener('click', e => {
    e.preventDefault();
    ssid= parseInt(getCookie("ssid"));
    if( !Number.isInteger(ssid) || ssid<1) {
        setCookie("ssid", "");
        render_window();
        return;
    }

    let start_timestamp= new Date(document.getElementById('filter_start_date').value);
    start_timestamp= start_timestamp.getTime()/1000;

    let end_timestamp= new Date(document.getElementById('filter_end_date').value);
    end_timestamp= end_timestamp.getTime()/1000;

    let fetch_url= rest_endpoint+"fetch_data.php?"+ new URLSearchParams({
        ssid: ssid,
        thread: document.getElementById('filter_thread').value,
        spend_amnt: document.getElementById('filter_spend').value,
        expence_type: document.getElementById('filter_expence_type').value,
        start_time: start_timestamp,
        end_time: end_timestamp,

    });

    console.log(fetch_url);

    // fetch(fetch_url)
    // .then(res => res.text())
    // .then(res => console.log(res))


    show_loading();

    fetch(fetch_url)
    .then(res => res.json())
    .then(res => {
        if(res.success == 'true') {
            let d= make_table_with_data(res.data);
            document.getElementById("expences_list").innerHTML= d;
        }
        else {
            show_error("Could not filter data!");
            console.log(res);
        }
    })
    .catch(err => {
        show_error("Could not filter! err in Connection!");
        console.error(err);
    })
    .finally(() => {
        hide_loading();
    })

}, false);







document.getElementById("undo_insert").addEventListener('click', e => {
    e.preventDefault();
    ssid= parseInt(getCookie("ssid"));
    if( !Number.isInteger(ssid) || ssid<1) {
        setCookie("ssid", "");
        render_window();
        return;
    }

    let fetch_url= rest_endpoint+"undo_insert.php?"+ new URLSearchParams({
        ssid: ssid,
    });


    let conf= prompt('type "confirm" to undo')
    if(conf) conf= conf.replace(/\s/g,'').replace(/\"/g, '').toLowerCase();

    if(conf!="confirm") {
        show_error('Please type "confirm" to undo last insert!');
        return;
    }

    show_loading();

    fetch(fetch_url)
    .then(res => res.json())
    .then(res => {
        if(res.success == 'true') {
            show_warning("Undo success...")
        }
        else {
            show_error("Could not Undo!");
            console.log(res);
        }
    })
    .catch(err => {
        show_error("Could not filter! err in Connection!");
        console.error(err);
    })
    .finally(() => {
        hide_loading();
        render_window();
    })

}, false);



