const colorIdData = {
    1: {
        borderStyle: '3px solid yellow',
        backgroundBord: '#EDEB52',
        boardColorAvatar: '#FFFF00',
        colorAddress: 'black',
        colorPower: 'black',
        avatarSrc: '../../../images/extra_objects/iconaplayB.png',
        textDecorationAddress: 'black',
    },
    2: {
        borderStyle: '3px solid red',
        backgroundBord: '#EE3634',
        boardColorAvatar: '#FF0000',
        colorAddress: 'black',
        colorPower: 'black',
        avatarSrc: '../../../images/extra_objects/iconaplayB.png',
        textDecorationAddress: 'black',
    },
    3: {
        borderStyle: '3px solid blue',
        backgroundBord: '#3C5FA1',
        boardColorAvatar: '#0000FF',
        colorAddress: 'white',
        colorPower: 'white',
        avatarSrc: '../../../images/extra_objects/iconaplayW.png',
        textDecorationAddress: 'white',
    },
    4: {
        borderStyle: '3px solid #EE5E81',
        backgroundBord: '#EE5E81',
        boardColorAvatar: '#ee5e81',
        colorAddress: 'black',
        colorPower: 'black',
        avatarSrc: '../../../images/extra_objects/iconaplayB.png',
        textDecorationAddress: 'black',
    },
    5: {
        borderStyle: '3px solid black',
        backgroundBord: 'black',
        colorAddress: 'white',
        colorPower: 'white',
        avatarSrc: '../../../images/extra_objects/iconaplayW.png',
        textDecorationAddress: 'white',
    },
    6: {
        borderStyle: '3px solid white',
        backgroundBord: 'white',
        colorAddress: 'black',
        colorPower: 'black',
        avatarSrc: '../../../images/extra_objects/iconaplayB.png',
        textDecorationAddress: 'black',
    },
}
export function getDefinitiveColorIdFromUserData(userData) {
    let colors = []
    if (userData.nft_7_color4) {
        colors.push(4)
    }
    if (userData.nft_6_color3) {
        colors.push(3)
    }
    if (userData.nft_5_color2) {
        colors.push(2)
    }
    if (userData.nft_4_color1) {
        colors.push(1)
    }
    return colors.length
        ? colors[Math.floor(Math.random() * colors.length)]
        : 1
}
export function getColorStyles(colorId) {
    if (colorIdData[colorId]) {
        return colorIdData[colorId];
    } else {
        const randomKey =  1
        return colorIdData[randomKey]
    }
}
