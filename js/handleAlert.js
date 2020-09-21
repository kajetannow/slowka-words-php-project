function handleAlert(msg, type="accept", headline="Udało się!"){
    var alert = document.createElement('div');
    var p = document.createElement('p');
    var h = document.createElement('h2');
    alert.classList.add("alert");
    alert.classList.add(type);
    msg = msg.toString();
    p.innerText = msg;
    h.innerText = headline;
    alert.appendChild(h);
    alert.appendChild(p);
    document.body.appendChild(alert);
    setTimeout(()=>alert.style.animationName = "fadeOut80percent",2700);
    setTimeout(()=>document.body.removeChild(alert),3000);
}