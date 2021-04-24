
        let pharmName    = document.querySelector('.pharm-name');
        let pharmAddress = document.querySelector('.pharm-address');
        let pharmPhone   = document.querySelector('.pharm-phone');
        let filtersbtn   = document.querySelector('.filtersbtn');
        let filtescontainer = document.querySelector('.filters-container');
        // Show Filters Section
        filtersbtn.addEventListener('click', function(e) {
            e.preventDefault();
            if(filtescontainer.style.display == 'block'){
                filtescontainer.style.display = 'none';
            } else {
                filtescontainer.style.display = 'block';
            }
            
        });

        // Filter By Pharmacy Name
        pharmName.addEventListener('keyup', function (e) {
            filterPharmacies(e.target.value, 'name');
        });

        // Filter By  Pharmacy Address
        pharmAddress.addEventListener('keyup', function (e) {
            filterPharmacies(e.target.value, 'address');
        });

        // Filter By  Pharmacy Phone
        pharmPhone.addEventListener('keyup', function (e) {
            filterPharmacies(e.target.value, 'phone');
        });


        let pendingRows = Array.from(document.querySelectorAll('.pharmacies .pharmacy'));

        function filterPharmacies(searchValue, subject) {

            matchedRows = pendingRows.filter(row => {
                if (subject == 'name') {
                    return row.querySelector('.name').innerText.match(searchValue);
                } else if (subject == 'address') {
                    return row.querySelector('.address').innerText.match(searchValue);
                } else if (subject == 'phone') {
                    return row.querySelector('.phone').innerText.match(searchValue);
                }
            })

            pendingRows.forEach(r => {
                if (matchedRows.includes(r)) {
                    r.style.display = 'block';
                } else {
                    r.style.display = 'none';
                }
            });

        }