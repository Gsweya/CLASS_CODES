import React from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import { useFont } from '../../contexts/FontContext';

interface Props {
  id: string;
  title: string;
  icon?: React.ReactNode;
  description?: string;
}

const SectionHeader: React.FC<Props> = ({ id, title, icon, description }) => {
  const { theme } = useTheme();
  const { uiFont } = useFont();
  const isDark = theme === 'dark';
  const textColor = isDark ? '#e0e0e0' : '#333';
  const accentColor = isDark ? '#4a9eff' : '#2196F3';

  return (
    <div id={id} style={{ 
      scrollMarginTop: '100px',
      marginBottom: '25px',
      paddingBottom: '15px',
      borderBottom: `2px solid ${isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'}`
    }}>
      <h2 style={{
        color: textColor,
        fontSize: '28px',
        fontWeight: '700',
        margin: 0,
        marginBottom: description ? '8px' : '0',
        display: 'flex',
        alignItems: 'center',
        gap: '12px',
        fontFamily: uiFont
      }}>
        {icon && <span style={{ color: accentColor }}>{icon}</span>}
        {title}
      </h2>
      {description && (
        <p style={{
          color: isDark ? '#aaa' : '#666',
          fontSize: '14px',
          margin: 0,
          fontFamily: uiFont
        }}>
          {description}
        </p>
      )}
    </div>
  );
};

export default SectionHeader;
