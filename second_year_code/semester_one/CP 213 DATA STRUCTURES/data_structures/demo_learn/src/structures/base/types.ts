// Base types for all data structures

export type StructureCategory = 'linear' | 'non-linear';

export interface Operation {
  id: string;
  name: string;
  description: string;
  execute: () => void;
}

export interface GuideContent {
  title: string;
  sections: GuideSection[];
}

export interface GuideSection {
  id: string;
  title: string;
  content: string;
  code?: string;
  interactive?: boolean;
}

export interface DataStructureConfig {
  id: string;
  name: string;
  category: StructureCategory;
  description: string;
  icon?: string;
  available: boolean;
}

