export function hideUsername(username = "", char = "*"){
    if(username.length <= 6){
        return username.substring(0, 1) + char.repeat(username.length - 2 ) + username.substring(username.length - 1);
    }
    return username.substring(0, 2) + char.repeat(username.length - 4 ) + username.substring(username.length - 2);
}