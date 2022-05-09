class AlertManager
{
    className = 'alerts';

    constructor(className)
    {
        this.className = className;
    }

    clearAll()
    {
        let divAlert = document.getElementsByClassName(this.className)[0];
        divAlert.innerHTML = '';
    }

    addAlert(message,status)
    {
        let divAlert = document.getElementsByClassName(this.className)[0];
        let div = document.createElement('div');
        div.innerHTML = `<div class="alert alert-${status}" role="alert">${message}</div>`;
        divAlert.appendChild(div);
    }
}
