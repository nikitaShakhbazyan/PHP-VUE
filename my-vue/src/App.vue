<template>
  <div class="container">
    <h1 class="header">Welcome to Our Website!</h1>
    <div class="button-container">
      <button class="button" @click="handleButtonClick('BTN 1')">BTN 1</button>
      <button class="button" @click="handleButtonClick('BTN 2')">BTN 2</button>
      <button class="button" @click="handleButtonClick('BTN 3')">BTN 3</button>
    </div>
    <h2 class="visit-info">You have visited this website {{ websiteViews }} times</h2>
    <div class="articles">
      <h2 class="article-title">Latest Articles</h2>
      <div class="article">
        <h3 class="article-heading">Article 1</h3>
        <p class="article-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="article">
        <h3 class="article-heading">Article 2</h3>
        <p class="article-content">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      </div>
      <div class="article">
        <h3 class="article-heading">Article 3</h3>
        <p class="article-content">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const buttonClickCount = ref(0);
    const startTime = ref(new Date());
    const endTime = ref(null);
    const websiteViews = ref(0);
    const visibleTime = ref(0);
    let visibilityStartTime = new Date();

    const handleButtonClick = async (buttonName) => {
      buttonClickCount.value++;
      endTime.value = new Date();
      await sendDataToServer();
    };

    const sendDataToServer = async () => {
      const totalTimeSpentMs = visibleTime.value + (new Date() - visibilityStartTime);
      const os = getOperatingSystem();

      let ip;
      try {
        ip = await getClientIpAddress();
      } catch (error) {
        console.error("Ошибка при получении IP-адреса:", error);
        ip = 'Unknown';
      }

      const data = {
        website_views: websiteViews.value,
        time_spent: parseInt(Math.round(totalTimeSpentMs / 1000)),
        btn_clicked: buttonClickCount.value,
        OS: os,
        IP: ip
      };

      try {
        const response = await axios.post("http://localhost:8081/views", data);
        if (response.status === 200 || response.status === 201) {
          console.log("Данные успешно отправлены на сервер");
        } else {
          console.error("Не удалось отправить данные:", response.statusText);
        }
      } catch (error) {
        console.error("Ошибка:", error);
      }
    };

    const handleVisibilityChange = () => {
      if (document.hidden) {
        visibleTime.value += new Date() - visibilityStartTime;
      } else {
        visibilityStartTime = new Date();
      }
    };

    const getOperatingSystem = () => {
      const userAgent = navigator.userAgent || navigator.vendor || window.opera;
      if (/android/i.test(userAgent)) {
        return "Android";
      }
      if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
      }
      if (/Windows/.test(userAgent)) {
        return "Windows";
      }
      if (/Macintosh|MacIntel|MacPPC|Mac68K/.test(userAgent)) {
        return "Mac OS";
      }
      if (/Linux/.test(userAgent)) {
        return "Linux";
      }
      return "Unknown";
    };

    const getClientIpAddress = () => {
      return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "https://api64.ipify.org?format=json", true);
        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.responseText);
            resolve(response.ip);
          } else {
            reject(xhr.statusText);
          }
        };
        xhr.onerror = function () {
          reject(xhr.statusText);
        };
        xhr.send();
      });
    };

    onMounted(() => {
      websiteViews.value = parseInt(localStorage.getItem('visits')) || 0;
      websiteViews.value++;
      localStorage.setItem('visits', websiteViews.value.toString());
      console.log('Количество посещений:', websiteViews.value);
      window.addEventListener('beforeunload', sendDataToServer);
      document.addEventListener('visibilitychange', handleVisibilityChange);
    });

    onBeforeUnmount(() => {
      window.removeEventListener('beforeunload', sendDataToServer);
      document.removeEventListener('visibilitychange', handleVisibilityChange);
    });

    return {
      buttonClickCount,
      startTime,
      endTime,
      websiteViews,
      handleButtonClick
    };
  }
};
</script>

<style scoped>
.container {
  text-align: center;
  margin-top: 50px;
}
.header {
  font-size: 24px;
  margin-bottom: 20px;
}
.button-container {
  display: flex;
  justify-content: center;
}
.button {
  margin: 0 10px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  outline: none;
}
.button:hover {
  background-color: #45a049;
}
.visit-info {
  margin-top: 20px;
  font-size: 18px;
}
.articles {
  margin-top: 50px;
}
.article-title {
  font-size: 20px;
  margin-bottom: 20px;
}
.article {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 20px;
}
.article-heading {
  font-size: 18px;
  margin-bottom: 10px;
}
.article-content {
  font-size: 16px;
}
</style>
