class UsersList
{
    constructor(id) {
        this.id = id;
    }

    appendChild(child)
    {
        let ul = document.getElementById(this.id);
        var li = document. createElement("li");
        li.innerHTML = UserListItem.buildHtml(child);
        ul. appendChild(li);

        return this;
    }
}
