var isUniqueVisit = 0
if (sessionStorage.getItem("xso-visit") != "visit") {
    isUniqueVisit = 1
} 
sessionStorage.setItem("xso-visit", "visit")

var domainSplit = window.location.host.split(".");
var domain = ""
for (var i = 0; i < domainSplit.length; i++) {
    if (domainSplit[i] != "www") {
        if (domain != "") {
            domain += "."
        }
        domain += domainSplit[i];
    }
}
const data = {
    "isUniqueVisit": isUniqueVisit,
    "domain": domain,
    "location": window.location.pathname
};
fetch("https://visitors.xsorexia.com/api/visitPage.php", {
    method: "POST",  // HTTP method
    headers: {
        "Content-Type": "application/json"  // Specify JSON format
    },

    body: JSON.stringify(data)  // Convert the data object to a JSON string
})
