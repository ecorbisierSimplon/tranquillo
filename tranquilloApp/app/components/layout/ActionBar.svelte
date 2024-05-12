<actionBar title="">
  <stackLayout orientation="vertical">
    <!-- <image src="~/lib/img/logo_tranquillo_app.png" height="60" /> -->
    <label text="Tranquillo Organizer" class="title" />
    <label text="App" class="title app" textAlignment="right" />
  </stackLayout>
</actionBar>

<style lang="scss">
  actionBar {
    background-color: hsl(45, 100%, 85%);
    // background-color: hsl(221, 100%, 79%);
    font-size: 0;
    border-bottom-width: 2px;
    border-bottom-style: solid;
    border-bottom-color: hsl(221, 54%, 52%);
    box-shadow: 15px 15px 10px 1px #8a8a8a;
    & label {
      font-size: 30;
      color: hsl(221, 60%, 35%);
      text-shadow:
        5px 5px 5px 1px #4d4d4d,
        2px 2px 5px 1px #464545;
    }
    & .app {
      color: hsl(45, 83%, 41%);
      font-size: 15;
      padding: 2;
      margin: -20 10 0 0;
    }
  }
</style>
