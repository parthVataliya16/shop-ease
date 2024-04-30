<div class="loader hideLoader">
    <div class="spin"></div>
</div>

<style>

.loader {
   position: fixed;
    align-items: center;
    justify-content: center;
    display: flex;
    height: 100vh;
    width: 100%;
    background-color: #e7e2e257;
    z-index: 2;
}

.hideLoader {
   display: none;
}

.spin {
   width: 56px;
   height: 56px;
   display: grid;
   border-radius: 50%;
   -webkit-mask: radial-gradient(farthest-side,#0000 40%,#474bff 41%);
   background: linear-gradient(0deg ,rgba(71,75,255,0.5) 50%,rgba(71,75,255,1) 0) center/4.5px 100%,
        linear-gradient(90deg,rgba(71,75,255,0.25) 50%,rgba(71,75,255,0.75) 0) center/100% 4.5px;
   background-repeat: no-repeat;
   animation: spin-d3o0rx 1s infinite steps(12);
}

.spin::before,
.spin::after {
   content: "";
   grid-area: 1/1;
   border-radius: 50%;
   background: inherit;
   opacity: 0.915;
   transform: rotate(30deg);
}

.spin::after {
   opacity: 0.83;
   transform: rotate(60deg);
}

@keyframes spin-d3o0rx {
   100% {
      transform: rotate(1turn);
   }
}
</style>