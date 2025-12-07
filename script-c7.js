/* ==========================================================
 * Curs 7 – JS DOM + Evenimente
 * ----------------------------------------------------------
 * Secțiuni:
 *  1) Selectori DOM + logging
 *  2) Modificare conținut, stil, clase
 *  3) Evenimente (click, mouseover/out)
 *  4) Form: citire valori, preview, validare simplă
 *  5) Mini-proiect: toggle temă light/dark
 * ==========================================================*/

/* ---------- Helpers ---------- */
function logLine(msg) {
  const box = document.getElementById('log-body');
  box.textContent += (box.textContent ? '\n' : '') + msg;
}

/* ---------- 1) DOM & Selectori ---------- */
const btnLog = document.getElementById('btn-log');
const btnHi  = document.getElementById('btn-hi');

btnLog.addEventListener('click', () => {
  const titlu = document.getElementById('titlu');
  const pPrimul = document.querySelector('p.muted');      // primul <p> cu .muted
  const totiP = document.querySelectorAll('p.muted');      // NodeList cu toate <p>.muted
  logLine('getElementById("titlu") → ' + (titlu ? 'OK' : 'NU'));
  logLine('querySelector("p.muted") → ' + (pPrimul ? 'OK' : 'NU'));
  logLine('querySelectorAll("p.muted") → ' + totiP.length + ' elemente');
  console.log({ titlu, pPrimul, totiP }); // vizual în consolă
});

btnHi.addEventListener('click', () => {
  const titlu = document.getElementById('titlu');
  titlu.innerText = 'Salut din JavaScript! 👋';
  logLine('Titlul a fost schimbat cu innerText.');
});

/* ---------- 2) Conținut, stil, clase ---------- */
const btnText  = document.getElementById('btn-text');
const btnHtml  = document.getElementById('btn-html');
const btnStyle = document.getElementById('btn-style');
const btnClass = document.getElementById('btn-class');
const textEl   = document.getElementById('text');
const boxEl    = document.getElementById('box');

btnText.addEventListener('click', () => {
  textEl.innerText = 'Salut din JS! (innerText)';
});

btnHtml.addEventListener('click', () => {
  textEl.innerHTML = 'Acesta este <strong>HTML</strong> dinamic (innerHTML).';
});

btnStyle.addEventListener('click', () => {
  // demonstrăm manipularea stilurilor inline
  textEl.style.color = '#0a6cff';
  textEl.style.fontSize = '1.25rem';
  textEl.style.fontWeight = '700';
});

btnClass.addEventListener('click', () => {
  boxEl.classList.toggle('highlight'); // adaugă/elimină clasa
});

/* ---------- 3) Evenimente ---------- */
const btnClick = document.getElementById('buton-click');
const statusEl = document.getElementById('status');
const hoverBox = document.getElementById('hover-zone');

btnClick.addEventListener('click', () => {
  statusEl.textContent = 'status: ai făcut click ✅';
  statusEl.classList.add('highlight');
  setTimeout(() => statusEl.classList.remove('highlight'), 800);
});

hoverBox.addEventListener('mouseover', () => {
  hoverBox.classList.add('highlight');
  hoverBox.style.cursor = 'pointer';
});
hoverBox.addEventListener('mouseout', () => {
  hoverBox.classList.remove('highlight');
});

/* ---------- 4) Formulare ---------- */
const form = document.getElementById('contact');
const previewBtn = document.getElementById('preview');
const feedback = document.getElementById('feedback');

previewBtn.addEventListener('click', () => {
  const nume = document.getElementById('nume').value.trim();
  const email = document.getElementById('email').value.trim();
  const mesaj = document.getElementById('mesaj').value.trim();
  feedback.classList.remove('hidden', 'warn', 'err');
  feedback.classList.add('msg');
  feedback.innerText = `Preview:\nNume: ${nume || '(gol)'}\nEmail: ${email || '(gol)'}\nMesaj: ${mesaj || '(gol)'}`;
});

form.addEventListener('submit', (e) => {
  e.preventDefault(); // nu trimitem nicăieri, doar validăm simplu în demo
  const nume = document.getElementById('nume').value.trim();
  const email = document.getElementById('email').value.trim();
  const mesaj = document.getElementById('mesaj').value.trim();

  // validare minimă
  if (!nume || !email) {
    feedback.classList.remove('hidden', 'msg', 'err');
    feedback.classList.add('warn');
    feedback.innerText = 'Te rugăm să completezi cel puțin numele și emailul.';
    return;
  }
  feedback.classList.remove('hidden', 'warn', 'err');
  feedback.classList.add('msg');
  feedback.innerText = 'Formular trimis (simulat) ✅ Mulțumim!';
  // poți reseta formularul:
  // form.reset();
});

/* ---------- 5) Mini-proiect: Toggle temă ---------- */
const temaBtn = document.getElementById('tema');
const temaStatus = document.getElementById('tema-status');
let dark = false;

temaBtn.addEventListener('click', () => {
  dark = !dark;
  if (dark) {
    document.documentElement.style.setProperty('--bg', '#0b1220');
    document.documentElement.style.setProperty('--ink', '#e5e7eb');
    document.documentElement.style.setProperty('--surface', '#0f172a');
    document.documentElement.style.setProperty('--border', '#1f2b46');
    document.documentElement.style.setProperty('--brand', '#5ea1ff');
    temaStatus.textContent = 'tema: dark';
  } else {
    document.documentElement.style.setProperty('--bg', '#ffffff');
    document.documentElement.style.setProperty('--ink', '#1f2937');
    document.documentElement.style.setProperty('--surface', '#f8fafc');
    document.documentElement.style.setProperty('--border', '#e5e7eb');
    document.documentElement.style.setProperty('--brand', '#0a6cff');
    temaStatus.textContent = 'tema: light';
  }
});