<template>
  <div class="register">
    <Header />
    <div class="container">
      <h2 class="title">新規登録</h2>
        <form @submit.prevent="registerFirebase">
          <validation-provider v-slot="ProviderProps" rules="required|max:20">
            <input type="text" v-model="name" name="name" placeholder="ユーザーネーム" />
            <div class="error">{{ ProviderProps.errors[0] }}</div>
          </validation-provider>
          <validation-provider v-slot="ProviderProps" rules="email|required">
            <input type="email" v-model="email" name="email" placeholder="メールアドレス" />
            <div class="error">{{ ProviderProps.errors[0] }}</div>
          </validation-provider>
          <validation-provider v-slot="ProviderProps" rules="min:6|required">
            <input type="password" v-model="password" name="password" placeholder="パスワード" />
            <div class="error">{{ ProviderProps.errors[0] }}</div>
          </validation-provider>
          <button class="btn" type="submit">新規登録</button>
        </form>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return{
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    registerFirebase() {
      if(!this.email || !this.password) {
        alert('メールアドレスまたはパスワードが入力されていません。')
        return
      }
      firebase
        .auth()
        .createUserWithEmailAndPassword(this.email, this.password)
        .then((result) => {
          result.user.updateProfile({
            displayName:this.name
          })
          this.registerBackend()
          alert("登録が完了しました。")
          this.$router.replace('/')
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/email-already-in-use':
              alert('このメールアドレスはすでに使われています。')
              break
            case 'auth/weak-password':
              alert('パスワードは6文字以上で入力してください。')
              break
            default:
              alert('エラーが起きました。しばらくしてから再度お試しください。')
              break
          }
        })
    },
    async registerBackend() {
      const sendData = {
        name: this.name,
        email: this.email,
        password: this.password
      };
      await this.$axios.post("http://127.0.0.1:8000/api/user/", sendData);
    },
  },
}
</script>

<style scoped>
.title{
  color: #000;
  font-size: 1.5rem;
  margin: 30px 0;
}
  .register {
    width: 100%;
  }
  .container {
    margin: auto;
    width: 30%;
    height: auto;
    background-color: white;
    text-align: center;
    padding: 5px 10px;
  }
  input {
    display: block;
    margin: auto;
    width: 80%;
    height: 30px;
    margin-bottom: 15px;
    border-radius: 10px;
    font-size: 1.1rem;
    padding: 5px;
  }
  .btn {
    color: #fff;
    background-color: #3B14A7;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    margin-bottom: 15px;
  }
  .error {
    margin-bottom: 5px;
    color: red;
  }
</style>