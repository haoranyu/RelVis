// credit: http://processingjs.nihongoresources.com/interfacing/
var pjs;
var canvasid = "pVis";
var sourcedir = "";
var sourcefiles = ["processing/contactVis/contactVis.pde", "processing/contactVis/contact.pde"];
var sourcecode = "";

// IE Unfriendly xhr Method
function ajaxget(url) {
    var xhr = new window.XMLHttpRequest();
    if (xhr) {
        xhr.open("GET", url, false);
        xhr.send(null);
    return xhr.responseText; }
    else { return false; }
}

function loadSourceCode() {
    if(sourcecode == "") {
        for (var j=0, fl=sourcefiles.length; j<fl; j++) {
            var sourcefile = sourcefiles[j];
            if (sourcefile) { sourcecode += ajaxget(sourcedir + sourcefile) + ";\n"; }}}
}

function loadPJS() {
    loadSourceCode();
    var canvas = document.getElementById(canvasid);
    pjs = new Processing(canvas, sourcecode);
    pjs.setJavaScript(this);
}

// endcredit

// vars for processing
var numContacts;

$(function() {
    numContacts = $("#contacts ul li").size();
    loadPJS();
});

function getSent(contactId) {
    contactId++;
    return $("#contacts ul li:nth-child("+ contactId +") a").attr('send');
}

function getReceived(contactId) {
    contactId++;
    return $("#contacts ul li:nth-child("+ contactId +") a").attr('receive');
}

function getOn(contactId) {
    contactId++;
    return $("#contacts ul li:nth-child("+ contactId +") a").attr('check');
}

function getLabel(contactId) {
    contactId++;
    return $("#contacts ul li:nth-child("+ contactId +")").text().replace(/\s+/g, '');
}
