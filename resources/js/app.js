import './bootstrap';
import './motion';
import { initSchedule } from './schedule';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', initSchedule);

