import React from 'react';
import { 
  FiInfo, 
  FiAlertTriangle, 
  FiXCircle, 
  FiCheckCircle,
  FiPlay,
  FiPause,
  FiSkipForward,
  FiList,
  FiCode,
  FiTarget,
  FiBook,
  FiHelpCircle
} from 'react-icons/fi';

interface IconProps {
  name: 'info' | 'warning' | 'error' | 'success' | 'play' | 'pause' | 'step' | 'list' | 'code' | 'target' | 'book' | 'help';
  size?: number;
  color?: string;
  className?: string;
}

const iconMap = {
  info: FiInfo,
  warning: FiAlertTriangle,
  error: FiXCircle,
  success: FiCheckCircle,
  play: FiPlay,
  pause: FiPause,
  step: FiSkipForward,
  list: FiList,
  code: FiCode,
  target: FiTarget,
  book: FiBook,
  help: FiHelpCircle,
};

const Icon: React.FC<IconProps> = ({ name, size = 16, color, className }) => {
  const IconComponent = iconMap[name];
  if (!IconComponent) return null;

  return <IconComponent size={size} color={color} className={className} />;
};

export default Icon;

