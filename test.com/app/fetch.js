
const fields = ["id", "name", "price", "wholesale_price", "warehouse_1", "warehouse_2", "country", "note"];
const headers = {'Content-type': 'application/json'};
const tableElement = document.getElementById("table");

const addCell = (value, rowElement) => {
    const element = document.createElement("td");
    element.innerText = value;
    rowElement.appendChild(element);
};

const fillTable = (data) => {
    const tbodyElement = tableElement.querySelector("tbody");
    tbodyElement.innerHTML = "";

    if (tbodyElement) {
        if(data.length < 1){
            const noElement = document.createElement("td");
            noElement.colSpan = 8;
            noElement.style.fontSize = "50px";
            noElement.innerText = "Sorry, an empty set! Choose other filters!";
            tbodyElement.appendChild(noElement);
        }else{
            data.forEach((item) => {
                const rowElement = document.createElement("tr");

                fields.forEach((field) => {
                    addCell(item[field], rowElement);
                    });
                tbodyElement.appendChild(rowElement);
            });
        }
    }
};

document.getElementById("filters").addEventListener("submit", function(e){
    e.preventDefault();
    const body = {
        "price": document.getElementById("price").value,
        "from": document.getElementById("first").value,
        "to": document.getElementById("sec").value,
        "warehouse": document.getElementById("warehouse").value,
        "ml": document.getElementById("MoreLess").value,
        "pieces": document.getElementById("count").value
    }
    fetch('fetch.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: headers
    }).then((response) => {
        response.json().then((result) => {
            console.log(result);
            fillTable(result);
        });
    });
});




