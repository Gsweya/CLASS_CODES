import React, { useState } from 'react';
import { useTheme } from '../../contexts/ThemeContext';
import { useFont } from '../../contexts/FontContext';
import { FiMap, FiChevronDown, FiChevronUp, FiExternalLink } from 'react-icons/fi';

interface SiteMapItem {
  id: string;
  title: string;
  description: string;
  icon: string;
  subsections?: { id: string; title: string; description: string }[];
}

interface Props {
  onNavigate?: (sectionId: string) => void;
}

const SiteMap: React.FC<Props> = ({ onNavigate }) => {
  const { theme } = useTheme();
  const { uiFont } = useFont();
  const [isOpen, setIsOpen] = useState(false);
  const [expandedCategory, setExpandedCategory] = useState<string | null>(null);

  const isDark = theme === 'dark';
  const bgColor = isDark 
    ? 'rgba(20, 20, 30, 0.95)' 
    : 'rgba(255, 255, 255, 0.95)';
  const textColor = isDark ? '#e0e0e0' : '#333';
  const borderColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
  const accentColor = isDark ? '#4a9eff' : '#2196F3';
  const cardBg = isDark ? 'rgba(30, 30, 40, 0.6)' : 'rgba(240, 240, 240, 0.6)';

  const siteMapSections: SiteMapItem[] = [
    {
      id: 'overview',
      title: 'Overview',
      description: 'Introduction to Linked Lists and the visualizer',
      icon: '🏠',
      subsections: [
        { id: 'header', title: 'Header Section', description: 'Title and main navigation controls' }
      ]
    },
    {
      id: 'learn',
      title: 'Learning Resources',
      description: 'Educational content and tutorials',
      icon: '📚',
      subsections: [
        { id: 'learning-mode', title: 'Step-by-Step Tutorial', description: 'Interactive guided learning with 8 progressive steps' },
        { id: 'eli5', title: "Explain Like I'm 5", description: 'Simple, child-friendly explanations of complex concepts' },
        { id: 'line-by-line', title: 'Line-by-Line Code Explanations', description: 'Hover over code to see detailed explanations' },
        { id: 'educational-content', title: 'Educational Concepts', description: 'Restaurant analogy, game use cases, and pointer explanations' },
        { id: 'code-examples', title: 'Code Examples', description: 'Three complete C++ implementations from main.cpp, main_2.cpp, linked_list.cpp' }
      ]
    },
    {
      id: 'practice',
      title: 'Practice & Interactive Tools',
      description: 'Hands-on practice and experimentation',
      icon: '⚡',
      subsections: [
        { id: 'operations', title: 'Operations Panel', description: 'Quick buttons for Create, Insert, Delete, Traverse, Search operations' },
        { id: 'code-editor', title: 'C++ Code Editor', description: 'Execute C++ statements interactively and see results' },
        { id: 'visualization', title: 'Visualization Canvas', description: 'Live visual representation of the linked list structure' },
        { id: 'challenges', title: 'Challenges', description: 'Interactive coding challenges with scoring system' },
        { id: 'traversal-guide', title: 'Traversal Guide', description: 'Step-by-step guide to traversing linked lists' }
      ]
    },
    {
      id: 'algorithms',
      title: 'Algorithms & Sorting',
      description: 'Sorting and searching algorithms',
      icon: '🔄',
      subsections: [
        { id: 'sorting', title: 'Sorting Algorithms', description: 'Bubble Sort, Selection Sort, Insertion Sort, Merge Sort, Quick Sort demonstrations' },
        { id: 'search-algorithm', title: 'Search Algorithm', description: 'Linear search implementation with complexity analysis' }
      ]
    },
    {
      id: 'complexity',
      title: 'Complexity Analysis',
      description: 'Big O notation and performance analysis',
      icon: '📊',
      subsections: [
        { id: 'big-o-notation', title: 'Big O Notation Guide', description: 'Complete reference for time and space complexities' },
        { id: 'operation-complexities', title: 'Operation Complexities', description: 'Table showing O(1), O(n) operations' },
        { id: 'sorting-complexities', title: 'Sorting Complexities', description: 'Comparison of all sorting algorithm complexities' }
      ]
    },
    {
      id: 'references',
      title: 'References & Quick Guides',
      description: 'Quick reference materials',
      icon: '📖',
      subsections: [
        { id: 'references', title: 'Quick References', description: 'Complexity tables, Linked List vs Array comparison, patterns' },
        { id: 'complexity-table', title: 'Complexity Tables', description: 'Complete time and space complexity reference' }
      ]
    }
  ];

  const handleNavigate = (sectionId: string) => {
    if (onNavigate) {
      onNavigate(sectionId);
    }
    const element = document.getElementById(sectionId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  return (
    <div style={{
      position: 'fixed',
      top: '20px',
      right: '20px',
      zIndex: 998,
      maxWidth: isOpen ? '400px' : 'auto',
      transition: 'all 0.3s ease',
      fontFamily: uiFont
    }}>
      <button
        onClick={() => setIsOpen(!isOpen)}
        style={{
          background: bgColor,
          backdropFilter: 'blur(20px) saturate(180%)',
          WebkitBackdropFilter: 'blur(20px) saturate(180%)',
          border: `1px solid ${borderColor}`,
          borderRadius: '12px',
          padding: '12px 16px',
          color: textColor,
          cursor: 'pointer',
          display: 'flex',
          alignItems: 'center',
          gap: '10px',
          fontWeight: '600',
          fontSize: '14px',
          boxShadow: isDark ? '0 4px 16px rgba(0, 0, 0, 0.3)' : '0 4px 16px rgba(0, 0, 0, 0.1)',
          fontFamily: uiFont,
          transition: 'all 0.2s'
        }}
        onMouseEnter={(e) => {
          e.currentTarget.style.transform = 'scale(1.05)';
        }}
        onMouseLeave={(e) => {
          e.currentTarget.style.transform = 'scale(1)';
        }}
      >
        <FiMap size={18} />
        {isOpen ? 'Hide' : 'Show'} Site Map
      </button>

      {isOpen && (
        <div style={{
          background: bgColor,
          backdropFilter: 'blur(20px) saturate(180%)',
          WebkitBackdropFilter: 'blur(20px) saturate(180%)',
          border: `1px solid ${borderColor}`,
          borderRadius: '16px',
          padding: '25px',
          marginTop: '10px',
          maxHeight: '80vh',
          overflowY: 'auto',
          boxShadow: isDark ? '0 8px 32px rgba(0, 0, 0, 0.4)' : '0 8px 32px rgba(0, 0, 0, 0.15)',
          fontFamily: uiFont
        }}>
          <h3 style={{
            color: textColor,
            fontSize: '20px',
            fontWeight: '700',
            marginBottom: '20px',
            display: 'flex',
            alignItems: 'center',
            gap: '10px'
          }}>
            <FiMap size={22} color={accentColor} />
            Site Map
          </h3>

          {siteMapSections.map((section) => (
            <div
              key={section.id}
              style={{
                marginBottom: '15px',
                border: `1px solid ${borderColor}`,
                borderRadius: '12px',
                overflow: 'hidden',
                background: cardBg
              }}
            >
              <div
                onClick={() => setExpandedCategory(expandedCategory === section.id ? null : section.id)}
                style={{
                  padding: '15px',
                  cursor: 'pointer',
                  display: 'flex',
                  justifyContent: 'space-between',
                  alignItems: 'center',
                  transition: 'background 0.2s'
                }}
                onMouseEnter={(e) => {
                  e.currentTarget.style.background = isDark 
                    ? 'rgba(40, 40, 50, 0.8)' 
                    : 'rgba(250, 250, 250, 0.8)';
                }}
                onMouseLeave={(e) => {
                  e.currentTarget.style.background = 'transparent';
                }}
              >
                <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                  <span style={{ fontSize: '24px' }}>{section.icon}</span>
                  <div>
                    <div style={{ color: textColor, fontWeight: '600', fontSize: '16px' }}>
                      {section.title}
                    </div>
                    <div style={{ color: isDark ? '#aaa' : '#666', fontSize: '12px', marginTop: '2px' }}>
                      {section.description}
                    </div>
                  </div>
                </div>
                {section.subsections && (
                  expandedCategory === section.id ? 
                    <FiChevronUp size={18} color={textColor} /> : 
                    <FiChevronDown size={18} color={textColor} />
                )}
              </div>

              {expandedCategory === section.id && section.subsections && (
                <div style={{
                  padding: '10px 15px 15px 15px',
                  borderTop: `1px solid ${borderColor}`,
                  background: isDark ? 'rgba(15, 15, 20, 0.5)' : 'rgba(255, 255, 255, 0.3)'
                }}>
                  {section.subsections.map((sub) => (
                    <div
                      key={sub.id}
                      onClick={() => handleNavigate(sub.id)}
                      style={{
                        padding: '12px',
                        marginBottom: '8px',
                        borderRadius: '8px',
                        cursor: 'pointer',
                        border: `1px solid ${borderColor}`,
                        background: isDark ? 'rgba(30, 30, 40, 0.6)' : 'rgba(250, 250, 250, 0.6)',
                        transition: 'all 0.2s'
                      }}
                      onMouseEnter={(e) => {
                        e.currentTarget.style.background = isDark 
                          ? 'rgba(74, 158, 255, 0.2)' 
                          : 'rgba(33, 150, 243, 0.15)';
                        e.currentTarget.style.borderColor = accentColor;
                      }}
                      onMouseLeave={(e) => {
                        e.currentTarget.style.background = isDark 
                          ? 'rgba(30, 30, 40, 0.6)' 
                          : 'rgba(250, 250, 250, 0.6)';
                        e.currentTarget.style.borderColor = borderColor;
                      }}
                    >
                      <div style={{
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'flex-start'
                      }}>
                        <div style={{ flex: 1 }}>
                          <div style={{
                            color: accentColor,
                            fontWeight: '600',
                            fontSize: '14px',
                            marginBottom: '4px'
                          }}>
                            {sub.title}
                          </div>
                          <div style={{
                            color: isDark ? '#b0b0b0' : '#666',
                            fontSize: '12px',
                            lineHeight: '1.5'
                          }}>
                            {sub.description}
                          </div>
                        </div>
                        <FiExternalLink size={14} color={accentColor} style={{ marginLeft: '10px', marginTop: '2px' }} />
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default SiteMap;
