//Parameters: string with the controller were the function is called
//Returns: string with the path
function getControllerPath(controller) {
    var pathToController = "";
    var stop = false;
    window.location.href.split('/').forEach(function (name) {
        if (stop) {
            return;
        }
        if (name.toLowerCase() !== controller.toLowerCase()) {
            if (pathToController === "") {
                pathToController = name + "/";
            } else {
                pathToController += "/" + name;
            }
        } else {
            pathToController += "/" + name + "/";
            stop = true;
        }
    });
    if (pathToController.indexOf("#") !== -1) {
        pathToController = pathToController.split("#")[0] + "/";
    }
    return pathToController;
}

//Parameters: value to find the key, and a dictionaty Object type
//Returns: string with key
function getKeyByValue(value, dictionary) {
    if (dictionary !== Object(dictionary))
        throw new TypeError('Object.keys called on non-object');
    for (var p in dictionary) {
        if (dictionary[p] == value) {
            return p;
        }
    }
    return null;
}

//return today date with the format YYYY-MM-DD
function returnTodayDateDatabaseFormat() {
    var d = new Date();
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    return year + "-" + month + "-" + day;
}