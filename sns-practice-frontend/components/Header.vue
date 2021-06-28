<template>
    <header>
        <img src="../assets/img/logo.png">
        <nav class="nav">
            <ul class="menu">
                <li class="menu-item">
                    <nuxt-link to="/register">新規登録</nuxt-link>
                </li>
                <li class="menu-item">
                    <nuxt-link to="/">ログイン</nuxt-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<style scoped>
header{
    display: flex;
    height: 60px;
    margin-bottom: 100px;
    justify-content: space-between;
    align-items: center;
    background-color: #03256C;
}
img {
    height: 80%;
    margin-left: 20px;
}
.nav{
    margin-right: 20px;
}
.menu-item {
    list-style: none;
    display: inline-block;
    padding: 10px;
}
.menu-item a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}
</style>