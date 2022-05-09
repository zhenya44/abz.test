class API
{
    static getPositions(url,success,fail)
    {
        fetch('/api/positions/', {
            method: 'GET',
        }) .then(function(response) {
            return response.json();
        }) .then(function(data) {
            console.log(data);
            if(data.success) {
                success(data);
            } else {
                fail(data);
            }
        }) .catch(function(error) {
            fail(error);
        });
    }

    static async createToken(url)
    {
        const response = await fetch(url);
        const result = await response.json();
        return result;
    }

    static createUser(url, requestInfo, success, fail)
    {
        fetch(url, requestInfo)
            .then(function(response) {
                return response.json();
            }) .then(function(data) {
            console.log(data);
            if(data.success) {
                success(data);
            } else {
                fail(data);
            }
        }) .catch(function(error) {
            fail(error);
        });
    }

    static getUsers(url, success, fail, page = 1)
    {
        fetch(url)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log(data);
                if(data.success) {

                    if(page > data.total_pages){
                        return
                    }
                    success(data);

                } else {
                    fail(data);
                }
            })
            .catch(function(error) {
                fail(error);
            });
    }
}
