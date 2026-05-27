(function () {
  'use strict';

  const form = document.getElementById('age-form');
  const dobInput = document.getElementById('dob');
  const resultsSection = document.getElementById('results');
  const errorBox = document.getElementById('error-message');
  const clearBtn = document.getElementById('clear-btn');
  const backBtn = document.getElementById('back-btn');

  const secondsRing = document.getElementById('seconds-ring');
  const currentSecondEl = document.getElementById('value-current-second');
  const liveClockEl = document.getElementById('live-clock');
  const liveDateEl = document.getElementById('live-date');
  const secondsBar = document.getElementById('seconds-bar');
  const secondsFraction = document.getElementById('seconds-fraction');
  const secondsPanel = document.getElementById('seconds-panel');

  const RING_CIRCUMFERENCE = 326.73;

  const valueEls = {
    years: document.getElementById('value-years'),
    months: document.getElementById('value-months'),
    days: document.getElementById('value-days'),
    hours: document.getElementById('value-hours'),
    minutes: document.getElementById('value-minutes'),
    seconds: document.getElementById('value-seconds'),
  };

  let birthDate = null;
  let secondsTimer = null;

  function formatNumber(num) {
    return num.toLocaleString(undefined, { maximumFractionDigits: 0 });
  }

  function parseBirthDate(dateString) {
    if (!dateString) return null;

    const parts = dateString.split('-').map(Number);
    if (parts.length !== 3 || parts.some(Number.isNaN)) return null;

    const [year, month, day] = parts;
    const date = new Date(year, month - 1, day);

    if (
      date.getFullYear() !== year ||
      date.getMonth() !== month - 1 ||
      date.getDate() !== day
    ) {
      return null;
    }

    return date;
  }

  function calculateYears(birth, now) {
    let years = now.getFullYear() - birth.getFullYear();
    const monthDiff = now.getMonth() - birth.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && now.getDate() < birth.getDate())) {
      years -= 1;
    }

    return years;
  }

  function calculateMonths(birth, now) {
    let months = (now.getFullYear() - birth.getFullYear()) * 12;
    months += now.getMonth() - birth.getMonth();

    if (now.getDate() < birth.getDate()) {
      months -= 1;
    }

    return months;
  }

  function calculateAge(birth, now) {
    const diffMs = now.getTime() - birth.getTime();

    if (diffMs < 0) return null;

    return {
      years: calculateYears(birth, now),
      months: calculateMonths(birth, now),
      days: Math.floor(diffMs / 86400000),
      hours: Math.floor(diffMs / 3600000),
      minutes: Math.floor(diffMs / 60000),
      seconds: Math.floor(diffMs / 1000),
    };
  }

  const errorText = errorBox.querySelector('.error-text');

  function showError(message) {
    if (errorText) {
      errorText.textContent = message;
    } else {
      errorBox.textContent = message;
    }
    errorBox.classList.remove('hidden');
    errorBox.classList.add('flex');
    errorBox.setAttribute('aria-hidden', 'false');
    hideResults();
  }

  function hideError() {
    if (errorText) {
      errorText.textContent = '';
    } else {
      errorBox.textContent = '';
    }
    errorBox.classList.add('hidden');
    errorBox.classList.remove('flex');
    errorBox.setAttribute('aria-hidden', 'true');
  }

  function stopSecondsTimer() {
    if (secondsTimer !== null) {
      clearInterval(secondsTimer);
      secondsTimer = null;
    }
  }

  function showResults() {
    resultsSection.classList.remove('hidden');
    resultsSection.classList.add('flex');
    resultsSection.setAttribute('aria-hidden', 'false');
    document.body.classList.add('results-visible');
    backBtn.focus();
  }

  function hideResults() {
    resultsSection.classList.add('hidden');
    resultsSection.classList.remove('flex');
    resultsSection.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('results-visible');
  }

  function padTwo(num) {
    return String(num).padStart(2, '0');
  }

  function formatClockTime(now) {
    return padTwo(now.getHours()) + ':' + padTwo(now.getMinutes()) + ':' + padTwo(now.getSeconds());
  }

  function formatLiveDate(now) {
    return now.toLocaleDateString(undefined, {
      weekday: 'short',
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    });
  }

  function updateSecondsDisplay(now, age) {
    const sec = now.getSeconds();
    const progress = sec / 60;

    valueEls.seconds.textContent = formatNumber(age.seconds);

    if (currentSecondEl) {
      currentSecondEl.textContent = padTwo(sec);
    }

    if (secondsRing) {
      secondsRing.style.strokeDashoffset = String(RING_CIRCUMFERENCE * (1 - progress));
    }

    if (secondsBar) {
      secondsBar.style.width = (progress * 100) + '%';
    }

    if (secondsFraction) {
      secondsFraction.textContent = sec + ' / 60';
    }

    if (liveClockEl) {
      liveClockEl.textContent = formatClockTime(now);
    }

    if (liveDateEl) {
      liveDateEl.textContent = formatLiveDate(now);
    }

    if (secondsPanel) {
      secondsPanel.classList.remove('seconds-tick');
      void secondsPanel.offsetWidth;
      secondsPanel.classList.add('seconds-tick');
    }
  }

  function renderResults(age) {
    valueEls.years.textContent = formatNumber(age.years);
    valueEls.months.textContent = formatNumber(age.months);
    valueEls.days.textContent = formatNumber(age.days);
    valueEls.hours.textContent = formatNumber(age.hours);
    valueEls.minutes.textContent = formatNumber(age.minutes);

    updateSecondsDisplay(new Date(), age);
    showResults();
  }

  function startSecondsTimer() {
    stopSecondsTimer();

    secondsTimer = setInterval(function () {
      if (!birthDate) return;

      const now = new Date();
      const diffMs = now.getTime() - birthDate.getTime();

      if (diffMs < 0) {
        stopSecondsTimer();
        return;
      }

      const age = calculateAge(birthDate, now);
      valueEls.minutes.textContent = formatNumber(age.minutes);
      valueEls.hours.textContent = formatNumber(age.hours);
      valueEls.days.textContent = formatNumber(age.days);
      valueEls.months.textContent = formatNumber(age.months);
      updateSecondsDisplay(now, age);
    }, 1000);
  }

  function validateDate(dateString) {
    const birth = parseBirthDate(dateString);

    if (!birth) {
      return { valid: false, message: 'Please enter a valid date of birth.' };
    }

    const today = new Date();
    today.setHours(23, 59, 59, 999);

    if (birth.getTime() > today.getTime()) {
      return { valid: false, message: 'Date of birth cannot be in the future.' };
    }

    return { valid: true, birth: birth };
  }

  function handleCalculate(event) {
    event.preventDefault();
    hideError();
    stopSecondsTimer();

    const validation = validateDate(dobInput.value);

    if (!validation.valid) {
      showError(validation.message);
      birthDate = null;
      return;
    }

    birthDate = validation.birth;
    const now = new Date();
    const age = calculateAge(birthDate, now);

    renderResults(age);
    startSecondsTimer();
  }

  function handleBack() {
    hideResults();
    stopSecondsTimer();
    dobInput.focus();
  }

  function handleClear() {
    form.reset();
    hideError();
    stopSecondsTimer();
    birthDate = null;
    hideResults();
    dobInput.focus();
  }

  form.addEventListener('submit', handleCalculate);
  clearBtn.addEventListener('click', handleClear);
  backBtn.addEventListener('click', handleBack);

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !resultsSection.classList.contains('hidden')) {
      handleBack();
    }
  });

  dobInput.setAttribute('max', new Date().toISOString().split('T')[0]);
})();
