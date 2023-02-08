
function show_warning(msg) {
    let elem= document.createElement("p");
    elem.innerText = msg;
    elem.className= "warning";
    document.getElementById('msg_holder').appendChild(elem);
    setTimeout(() => {
        elem.remove();
    }, 4000);
}

function show_error(msg) {
    let elem= document.createElement("p");
    elem.innerText = msg;
    elem.className= "error";
    document.getElementById('msg_holder').appendChild(elem);
    setTimeout(() => {
        elem.remove();
    }, 7000);
}


function setCookie(cname, cvalue, exdays=365) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function to_two_digit(v) {
    v= parseInt(v);
    return v<10? "0"+v:v;
}


function make_table_with_data(data_arr) {
    if(data_arr=="[]") data_arr= "";

    let months= ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let res= "<table><tr>";
    res+="<th class='th_title'> DateTime </th>";
    res+="<th class='th_title'> Item </th>";
    res+="<th class='th_title'> Cost </th>";
    res+="</tr>";

    let last_date= -1, date_clr=-1;
    let total_days=0, total_expence= 0;

    let current_thread= -1, thread_updated_class= '';

    for(let data of data_arr) {
        let d = new Date(data.timestamp*1000);

        if(d.getDate()+31*d.getMonth() != last_date) {
            date_clr= (date_clr+1)%4;
            last_date= d.getDate()+31*d.getMonth();
            total_days+=1;
        }

        if(data.thread_id != current_thread) {
            thread_updated_class= 'th_new_thread';
            current_thread= data.thread_id;
        }

        total_expence+=data.cost;

        res+='<tr>';
        res+='<th class="dt_time date_clr_'+date_clr+ ' '+ thread_updated_class + '"> '+d.getDate() +"" +months[d.getMonth()];
        res+=' '+to_two_digit(d.getHours()) +":" +to_two_digit(d.getMinutes())+"</th>";
        res+='<th class="etype_'+data.expence_type+ ' '+ thread_updated_class + '"> '+data.item+" </th>";
        let cost_class= '';
        if(data.cost<=-8000) {
            cost_class= 'cost_neg_6';
        }
        if(data.cost<=-5000) {
            cost_class= 'cost_neg_5';
        }
        else if(data.cost<=-1900) {
            cost_class= 'cost_neg_4';
        }
        else if(data.cost<=-1000) {
            cost_class= 'cost_neg_3';
        }
        else if(data.cost<=-500) {
            cost_class= 'cost_neg_2';
        }
        else if(data.cost<=-100) {
            cost_class= 'cost_neg_1';
        }
        else if(data.cost<0) {
            cost_class= 'cost_neg_0';
        }
        else if(data.cost<100) {
            cost_class= 'cost_pos_1';
        }
        else if(data.cost<700) {
            cost_class= 'cost_pos_2';
        }
        else if(data.cost<2000) {
            cost_class= 'cost_pos_3';
        }
        else if(data.cost<5000) {
            cost_class= 'cost_pos_4';
        }
        else if(data.cost<10000) {
            cost_class= 'cost_pos_5';
        }
        else {
            cost_class= 'cost_pos_6';
        }
        res+='<th class="'+ cost_class + ' '+ thread_updated_class + '"> '+data.cost+" </th>";
        res+="</tr>";

        thread_updated_class= '';
    }
    res+='<tr><th>'+total_days+' days</th><th>---</th><th class="total_exp">'+total_expence+'</th></tr>';
    res+="</table>";
    return res;
}



function show_loading() {
    document.getElementById("loading_holder").style.display= "block";
}

function hide_loading() {
    document.getElementById("loading_holder").style.display= "none";
}


function show_add_data_window() {
    expences_window.style.filter= "blur(5px)";
    add_data_window.style.display= "block";
}

function hide_add_data_window() {
    expences_window.style.filter= "";
    add_data_window.style.display= "none";
}

function fill_expence_type_opts(div_to_insert_into) {


    for(let v of expences_types) {
        let key= v[0],  val= v[1];
        let el= document.createElement('option');
        el.value= key;
        el.innerHTML= val;
        div_to_insert_into.appendChild(el);
    }
}