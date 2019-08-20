function updateProgress() {

    $('#p').progressbar('setValue', 0);
    getStatus();
    myVar= setInterval('getStatus()', 3000);
    startProcess();

}