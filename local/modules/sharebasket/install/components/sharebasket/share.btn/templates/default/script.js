
function getShortUrl(){
    
    BX.ajax({
        url: '/local/components/sharebasket/share.btn/templates/default/ajax.php',
        data: 1,
        method: 'POST',
        dataType: 'json',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: true,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
            document.querySelector('#short-url').value = data;
        },
        onfailure: function(){
            console.log('ajax error');
        }
    }); 
}

let url = document.getElementById('short-url').innerHTML;
const copyURL = async () => {
    try {
      await navigator.clipboard.writeText(url);
      console.log('Content copied to clipboard');
    } catch (err) {
      console.error('Failed to copy: ', err);
    }
}
