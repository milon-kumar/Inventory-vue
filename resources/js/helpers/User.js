import Token from "./Token";
import Appstores from "./Appstores";

class User{
    responseAfterLogin(res){
        const accessToken = res.data.access_token;
        const userName = res.data.userName;

        if (Token.isValidToken(accessToken)){
            Appstores.storeAuth(accessToken, userName)
        }
    }

    hasToken(){
        const storageToken = localStorage.getItem('_token');
        if (storageToken){
            return Token.isValidToken(storageToken) ? true : false
        }
        false
    }

    loggedIn(){
        return this.hasToken();
    }

    logout(){
        Appstores.clearAuth();
    }

    name(){
        if (this.loggedIn()){
            return localStorage.getItem('_user')
        }
    }
    userId(){
        if (this.loggedIn()){
            const payload = Token.payload(localStorage.getItem('_token'));
            return payload.sub;
        }
        return  false
    }
    authToken(){
        if (this.loggedIn()){
            return localStorage.getItem('_token')
        }
    }


}

export default User = new User();
