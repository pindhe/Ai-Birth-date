(function () {
  'use strict';

  const form = document.getElementById('age-form');
  const dobInput = document.getElementById('dob');
  const resultsSection = document.getElementById('results');
  const errorBox = document.getElementById('error-message');
  const clearBtn = document.getElementById('clear-btn');

  const valueEls = {
    years: document.getElementById('value-years'),
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

  function calculateAge(birth, now) {
    const diffMs = now.getTime() - birth.getTime();

    if (diffMs < 0) return null;

    return {
      years: calculateYears(birth, now),
      days: Math.floor(diffMs / 86400000),
      hours: Math.floor(diffMs / 3600000),
      minutes: Math.floor(diffMs / 60000),
      seconds: Math.floor(diffMs / 1000),
    };
  }

  function showError(message) {
    errorBox.textContent = message;
    errorBox.classList.remove('hidden');
    errorBox.setAttribute('aria-hidden', 'false');
    resultsSection.classList.add('hidden');
    resultsSection.setAttribute('aria-hidden', 'true');
  }

  function hideError() {
    errorBox.textContent = '';
    errorBox.classList.add('hidden');
    errorBox.setAttribute('aria-hidden', 'true');
  }

  function stopSecondsTimer() {
    if (secondsTimer !== null) {
      clearInterval(secondsTimer);
      secondsTimer = null;
    }
  }

  function renderResults(age) {
    valueEls.years.textContent = formatNumber(age.years);
    valueEls.days.textContent = formatNumber(age.days);
    valueEls.hours.textContent = formatNumber(age.hours);
    valueEls.minutes.textContent = formatNumber(age.minutes);
    valueEls.seconds.textContent = formatNumber(age.seconds);

    resultsSection.classList.remove('hidden');
    resultsSection.setAttribute('aria-hidden', 'false');
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
      valueEls.seconds.textContent = formatNumber(age.seconds);
      valueEls.minutes.textContent = formatNumber(age.minutes);
      valueEls.hours.textContent = formatNumber(age.hours);
      valueEls.days.textContent = formatNumber(age.days);
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

  function handleClear() {
    form.reset();
    hideError();
    stopSecondsTimer();
    birthDate = null;
    resultsSection.classList.add('hidden');
    resultsSection.setAttribute('aria-hidden', 'true');
    dobInput.focus();
  }

  form.addEventListener('submit', handleCalculate);
  clearBtn.addEventListener('click', handleClear);

  dobInput.setAttribute('max', new Date().toISOString().split('T')[0]);
})();
